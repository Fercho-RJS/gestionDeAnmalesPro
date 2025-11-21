<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

$nombre = $_POST['nombre'] ?? null;
$tipo = $_POST['tipo'] ?? null;
$colorList = $_POST['colorList'] ?? null;
$fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
$raza = $_POST['raza'] ?? null;
$imagenUrl = $_FILES['imagenUrl'] ?? null;
$fechaAdopcion = $_POST['fechaAdopcion'] ?? null;
$tamanio = $_POST['tamanio'] ?? null;
$codigoAnimal = 1;

// Validación de campos obligatorios
if (empty($nombre) || empty($fechaNacimiento) || empty($raza) || empty($tipo) || empty($colorList) || empty($tamanio)) {
  header("Location: " . PUBLIC_PAGES_URL . "workspace/animals/form_new_animal.php?error=missing_fields");
  exit;
} else if (!empty($codigoAnimal)) {
  // Generar código único de chip
  do {
    $codigoAnimal = bin2hex(random_bytes(5));
    $validarCodigo = "SELECT chipNro FROM mascota WHERE chipNro = '$codigoAnimal'";
    $resultado = mysqli_query($conexion, $validarCodigo);
    $row = mysqli_fetch_assoc($resultado);
  } while ($row);
}

$edad = (int)date("Y") - (int)date("Y", strtotime($fechaNacimiento));
$propietario = $_SESSION['idUsuario'] ?? null;

if (empty($fechaAdopcion)) {
  $fechaAdopcion = null;
}

// Imagen por defecto
$rutaBD = PUBLIC_RESOURCES_IMAGES_URL . "animal.png";

// Si se sube una imagen personalizada
if (isset($_FILES['imagenUrl']) && $_FILES['imagenUrl']['error'] === UPLOAD_ERR_OK) {
  $directorio = $_SERVER['DOCUMENT_ROOT'] . PUBLIC_RESOURCES_ANIMAL_PROFILES_URL;
  if (!is_dir($directorio)) {
    mkdir($directorio, 0777, true);
  }
  $nombreArchivo = 'photo-' . time() . '-' . basename($_FILES['imagenUrl']['name']);
  $rutaCompleta = $directorio . $nombreArchivo;

  if (move_uploaded_file($_FILES['imagenUrl']['tmp_name'], $rutaCompleta)) {
    $rutaBD = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL . $nombreArchivo;
  }
}

// Insertar mascota
$sql = "INSERT INTO mascota (nombre, categoria, raza, edad, color, height, imagen, chipNro, status, Usuario_idUsuario) 
        VALUES ('$nombre', '$tipo', '$raza', '$edad', '$colorList', '$tamanio', '$rutaBD', '$codigoAnimal', 'Adoptado', '$propietario')";
$result = mysqli_query($conexion, $sql);

if ($result) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=mascota_registrada");
  exit;
} else {
  echo "Error al registrar la mascota: " . mysqli_error($conexion);
}

mysqli_close($conexion);
