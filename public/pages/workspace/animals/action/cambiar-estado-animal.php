<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar sesión
if (!isset($_SESSION['rol']) || !isset($_SESSION['idUsuario'])) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=401");
  exit("No autenticado.");
}

$idMascota   = isset($_GET['idMascota']) ? (int)$_GET['idMascota'] : 0;
$nuevoEstado = $_GET['nuevoEstado'] ?? '';
$estadosPermitidos = ['Adoptado', 'Perdido', 'En adopción', 'Pendiente'];

if ($idMascota <= 0 || !in_array($nuevoEstado, $estadosPermitidos, true)) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=402");
  exit("Parámetros inválidos.");
}

// Verificar que la mascota pertenece al usuario
$verificar = $conexion->prepare("
  SELECT idMascota FROM mascota 
  WHERE idMascota = ? AND Usuario_idUsuario = ?
  LIMIT 1
");
$verificar->bind_param("ii", $idMascota, $_SESSION['idUsuario']);
$verificar->execute();
$verificar->store_result();
if ($verificar->num_rows === 0) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=404");
  exit("Mascota no encontrada o no te pertenece.");
}
$verificar->close();

$conexion->begin_transaction();

try {
  // Actualizar estado en mascota
  $update = $conexion->prepare("UPDATE mascota SET status = ? WHERE idMascota = ?");
  $update->bind_param("si", $nuevoEstado, $idMascota);
  $update->execute();
  $update->close();

  // Si es Perdido
  if ($nuevoEstado === 'Perdido') {
    $existe = $conexion->prepare("
      SELECT Mascota_idMascota FROM perdidos 
      WHERE Mascota_idMascota = ? AND status = 'Perdido'
      LIMIT 1
    ");
    $existe->bind_param("i", $idMascota);
    $existe->execute();
    $existe->store_result();

    if ($existe->num_rows === 0) {
      $existe->close();
      $insert = $conexion->prepare("
        INSERT INTO perdidos (Mascota_idMascota, status, fecha_de_reporte) 
        VALUES (?, 'Perdido', CURDATE())
      ");
      $insert->bind_param("i", $idMascota);
      $insert->execute();
      $insert->close();
    } else {
      $existe->close();
    }

    // Eliminar adopciones si estaba en adopción
    $deleteAdopcion = $conexion->prepare("DELETE FROM adopciones WHERE Mascota_idMascota = ?");
    $deleteAdopcion->bind_param("i", $idMascota);
    $deleteAdopcion->execute();
    $deleteAdopcion->close();
  }

  // Si es En adopción
  if ($nuevoEstado === 'En adopción') {
    // Eliminar registros de perdidos
    $deletePerdido = $conexion->prepare("DELETE FROM perdidos WHERE Mascota_idMascota = ?");
    $deletePerdido->bind_param("i", $idMascota);
    $deletePerdido->execute();
    $deletePerdido->close();

    // Verificar adopción
    $checkAdopcion = $conexion->prepare("SELECT idAdopciones FROM adopciones WHERE Mascota_idMascota = ? LIMIT 1");
    $checkAdopcion->bind_param("i", $idMascota);
    $checkAdopcion->execute();
    $checkAdopcion->store_result();

    if ($checkAdopcion->num_rows === 0) {
      $checkAdopcion->close();
      $insertAdopcion = $conexion->prepare("
        INSERT INTO adopciones (Mascota_idMascota, estado, fecha_adopcion, Usuario_idUsuario)
        VALUES (?, 'En proceso', CURDATE(), ?)
      ");
      $insertAdopcion->bind_param("ii", $idMascota, $_SESSION['idUsuario']);
      $insertAdopcion->execute();
      $insertAdopcion->close();
    } else {
      $checkAdopcion->close();
      $updateAdopcion = $conexion->prepare("
        UPDATE adopciones 
        SET estado = 'En proceso', fecha_adopcion = CURDATE(), Usuario_idUsuario = ?
        WHERE Mascota_idMascota = ?
      ");
      $updateAdopcion->bind_param("ii", $_SESSION['idUsuario'], $idMascota);
      $updateAdopcion->execute();
      $updateAdopcion->close();
    }
  }

  // Si es Adoptado
  if ($nuevoEstado === 'Adoptado') {
    // Eliminar registros de perdidos
    $deletePerdido = $conexion->prepare("DELETE FROM perdidos WHERE Mascota_idMascota = ?");
    $deletePerdido->bind_param("i", $idMascota);
    $deletePerdido->execute();
    $deletePerdido->close();

    // Actualizar o insertar adopción
    $updateAdopcion = $conexion->prepare("
      UPDATE adopciones 
      SET estado = 'Vigente', fecha_adopcion = CURDATE(), Usuario_idUsuario = ?
      WHERE Mascota_idMascota = ?
    ");
    $updateAdopcion->bind_param("ii", $_SESSION['idUsuario'], $idMascota);
    $updateAdopcion->execute();

    if ($updateAdopcion->affected_rows === 0) {
      $updateAdopcion->close();
      $insertAdopcion = $conexion->prepare("
        INSERT INTO adopciones (Mascota_idMascota, estado, fecha_adopcion, Usuario_idUsuario)
        VALUES (?, 'Vigente', CURDATE(), ?)
      ");
      $insertAdopcion->bind_param("ii", $idMascota, $_SESSION['idUsuario']);
      $insertAdopcion->execute();
      $insertAdopcion->close();
    } else {
      $updateAdopcion->close();
    }
  }

  // Si es Pendiente (ej: reportar encuentro)
  if ($nuevoEstado === 'Pendiente') {
    // Eliminar cualquier registro previo en perdidos
    $deletePrev = $conexion->prepare("DELETE FROM perdidos WHERE Mascota_idMascota = ?");
    $deletePrev->bind_param("i", $idMascota);
    $deletePrev->execute();
    $deletePrev->close();

    // Insertar nuevo registro como Pendiente
    $insertPendiente = $conexion->prepare("
        INSERT INTO perdidos (Mascota_idMascota, status, fecha_de_reporte) 
        VALUES (?, 'Pendiente', CURDATE())
    ");
    $insertPendiente->bind_param("i", $idMascota);
    $insertPendiente->execute();
    $insertPendiente->close();
  }


  $conexion->commit();
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=201");
  exit();
} catch (Throwable $e) {
  $conexion->rollback();
  error_log('Error cambiar-estado-animal: ' . $e->getMessage());
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=500");
  exit("Error interno: " . $e->getMessage());
}
