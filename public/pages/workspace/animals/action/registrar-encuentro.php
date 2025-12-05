<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// ACTIVA errores en desarrollo (quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function fail($msg, $redirect = null) {
  // Muestra en pantalla en desarrollo, y redirige si se indica
  if ($redirect) {
    header("Location: {$redirect}");
    exit;
  }
  exit($msg);
}

// ----------------------------
// Captura de datos del form
// ----------------------------
$descripcion    = trim($_POST['descripcion'] ?? '');
$lugar          = trim($_POST['lugar'] ?? '');
$fechaEncuentro = $_POST['fechaEncuentro'] ?? null;

// Datos de contacto (pueden venir vacíos si no se usan)
$contactoNombre   = $_POST['contactoNombre'] ?? null;
$contactoTelefono = $_POST['contactoTelefono'] ?? null;
$contactoEmail    = $_POST['contactoEmail'] ?? null;

// Mascota
$idMascota = $_POST['idMascota'] ?? ($_GET['idMascota'] ?? null);
$idMascota = is_numeric($idMascota) ? (int)$idMascota : 0;

// Validación mínima
if ($descripcion === '' || $lugar === '' || empty($fechaEncuentro)) {
  fail("Faltan campos requeridos", PUBLIC_PAGES_URL . "pg_reportarEncuentro.php?error=missing_fields");
}
if ($idMascota <= 0) {
  fail("idMascota inválido", PUBLIC_PAGES_URL . "pg_reportarEncuentro.php?error=invalid_pet");
}

// ----------------------------
// Manejo de imagen
// ----------------------------
$rutaBD = PUBLIC_RESOURCES_IMAGES_URL . "animal.png"; // Valor por defecto
if (isset($_FILES['imagenMascota']) && $_FILES['imagenMascota']['error'] === UPLOAD_ERR_OK) {
  $directorioFisico  = $_SERVER['DOCUMENT_ROOT'] . "/public/res/animal_profiles/";
  $directorioPublico = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL;

  if (!is_dir($directorioFisico)) {
    if (!mkdir($directorioFisico, 0777, true)) {
      fail("No se pudo crear el directorio de imágenes");
    }
  }

  $nombreArchivo = 'encuentro-' . time() . '-' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES['imagenMascota']['name']));
  $rutaCompleta  = $directorioFisico . $nombreArchivo;

  if (move_uploaded_file($_FILES['imagenMascota']['tmp_name'], $rutaCompleta)) {
    $rutaBD = $directorioPublico . $nombreArchivo;
  }
}

// ----------------------------
// Transacción consistente
// ----------------------------
$conexion->begin_transaction();

try {
  // 1) Actualizar mascota: status Pendiente + imagen
  $sqlUpdate = "UPDATE mascota SET status = 'Pendiente', imagen = ? WHERE idMascota = ?";
  $stmt = $conexion->prepare($sqlUpdate);
  if ($stmt === false) {
    throw new RuntimeException("Error prepare UPDATE: " . $conexion->error);
  }
  $stmt->bind_param("si", $rutaBD, $idMascota);
  $stmt->execute();
  if ($stmt->affected_rows === 0) {
    // Si no afectó filas, puede ser que ya estuviera 'Pendiente' o idMascota no exista
    // Validamos que la mascota exista
    $stmt->close();
    $chk = $conexion->prepare("SELECT idMascota FROM mascota WHERE idMascota = ? LIMIT 1");
    $chk->bind_param("i", $idMascota);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows === 0) {
      $chk->close();
      throw new RuntimeException("La mascota no existe (idMascota={$idMascota})");
    }
    $chk->close();
  } else {
    $stmt->close();
  }

  // 2) Eliminar cualquier registro previo en perdidos (ya no debe mostrar)
  $sqlDelete = "DELETE FROM perdidos WHERE Mascota_idMascota = ?";
  $stmtDel = $conexion->prepare($sqlDelete);
  if ($stmtDel === false) {
    throw new RuntimeException("Error prepare DELETE: " . $conexion->error);
  }
  $stmtDel->bind_param("i", $idMascota);
  $stmtDel->execute();
  $stmtDel->close();

  // Si querés mantener un histórico de encuentros, acá podrías insertar en otra tabla (ej. encuentros)

  // Commit OK
  $conexion->commit();

  // Redirige a lista de espera (filtra por mascota.status = 'Pendiente')
  header("Location: " . PUBLIC_PAGES_URL . "pg_listaDeEspera.php?m=encuentro_reportado");
  exit;

} catch (Throwable $e) {
  // Rollback y error
  $conexion->rollback();
  // Muestra detalle en desarrollo; redirige con código en producción si preferís
  fail("Error interno: " . $e->getMessage(), PUBLIC_PAGES_URL . "pg_reportarEncuentro.php?error=server");
} finally {
  if ($conexion && $conexion->ping()) {
    $conexion->close();
  }
}
