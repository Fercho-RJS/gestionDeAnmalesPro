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

$idMascota = isset($_GET['idMascota']) ? (int)$_GET['idMascota'] : 0;
if ($idMascota <= 0) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_listaDeEspera.php?m=402");
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
  header("Location: " . PUBLIC_PAGES_URL . "pg_listaDeEspera.php?m=404");
  exit("Mascota no encontrada o no te pertenece.");
}
$verificar->close();

$conexion->begin_transaction();

try {
  // 1. Actualizar estado en mascota
  $update = $conexion->prepare("UPDATE mascota SET status = 'Adoptado' WHERE idMascota = ?");
  $update->bind_param("i", $idMascota);
  $update->execute();
  $update->close();

  // 2. Eliminar cualquier registro en perdidos (Pendiente o Perdido)
  $deletePerdido = $conexion->prepare("DELETE FROM perdidos WHERE Mascota_idMascota = ?");
  $deletePerdido->bind_param("i", $idMascota);
  $deletePerdido->execute();
  $deletePerdido->close();

  // 3. Actualizar o insertar adopción
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

  $conexion->commit();
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=encuentro_confirmado");
  exit();

} catch (Throwable $e) {
  $conexion->rollback();
  error_log('Error confirmar-encuentro: ' . $e->getMessage());
  header("Location: " . PUBLIC_PAGES_URL . "pg_listaDeEspera.php?m=500");
  exit("Error interno: " . $e->getMessage());
}
