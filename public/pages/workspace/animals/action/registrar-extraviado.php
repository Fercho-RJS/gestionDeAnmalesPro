<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

// Datos del formulario
$nombre       = $_POST['nombre'] ?? null;
$categoria    = $_POST['categoria'] ?? null;
$raza         = $_POST['raza'] ?? null;
$edad         = $_POST['edad'] ?? null;
$color        = $_POST['color'] ?? null;
$height       = $_POST['height'] ?? null;
$descripcion  = $_POST['descripcion'] ?? null;
$lugar        = $_POST['lugar'] ?? null;
$fechaReporte = $_POST['fecha_de_reporte'] ?? date('Y-m-d');
$imagenFile   = $_FILES['imagen'] ?? null;

// Validación de campos obligatorios
if (empty($nombre) || empty($categoria) || empty($color) || empty($descripcion) || empty($lugar)) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_reportarExtraviado.php?error=missing_fields");
  exit;
}

// Imagen por defecto
$rutaBD = PUBLIC_RESOURCES_IMAGES_URL . "animal.png";

// Si se sube una imagen personalizada
if ($imagenFile && $imagenFile['error'] === UPLOAD_ERR_OK) {
  $directorio = $_SERVER['DOCUMENT_ROOT'] . PUBLIC_RESOURCES_ANIMAL_PROFILES;
  if (!is_dir($directorio)) {
    mkdir($directorio, 0777, true);
  }
  $nombreArchivo = 'lost-' . time() . '-' . basename($imagenFile['name']);
  $rutaCompleta = $directorio . $nombreArchivo;

  if (move_uploaded_file($imagenFile['tmp_name'], $rutaCompleta)) {
    $rutaBD = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL . $nombreArchivo;
  }
}

// Insertar mascota
$sqlMascota = "INSERT INTO mascota (nombre, categoria, raza, edad, color, height, imagen, status) 
               VALUES (?, ?, ?, ?, ?, ?, ?, 'Perdido')";
$stmtMascota = $conexion->prepare($sqlMascota);
$stmtMascota->bind_param("sssisss", $nombre, $categoria, $raza, $edad, $color, $height, $rutaBD);

if ($stmtMascota->execute()) {
  $idMascota = $stmtMascota->insert_id;

  // Insertar en perdidos
  $sqlPerdido = "INSERT INTO perdidos (Mascota_idMascota, fecha_de_reporte, lugar, descripcion, status) 
                 VALUES (?, ?, ?, ?, 'Perdido')";
  $stmtPerdido = $conexion->prepare($sqlPerdido);
  $stmtPerdido->bind_param("isss", $idMascota, $fechaReporte, $lugar, $descripcion);

  if ($stmtPerdido->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_animalesPerdidos.php?m=reportado");
    exit;
  } else {
    echo "Error al registrar el reporte: " . $conexion->error;
  }
} else {
  echo "Error al registrar la mascota: " . $conexion->error;
}

$conexion->close();
?>
