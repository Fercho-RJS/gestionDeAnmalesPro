<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// Captura de datos del formulario
$idUsuario       = $_POST['idUsuario'] ?? null;
$descripcion     = trim($_POST['descripcion'] ?? '');
$lugar           = trim($_POST['lugar'] ?? '');
$fechaEncuentro  = $_POST['fechaEncuentro'] ?? null;

// Si es invitado, datos de contacto
$contactoNombre   = $_POST['contactoNombre'] ?? null;
$contactoTelefono = $_POST['contactoTelefono'] ?? null;
$contactoEmail    = $_POST['contactoEmail'] ?? null;

// Imagen subida
$rutaBD = PUBLIC_RESOURCES_IMAGES_URL . "animal.png"; // por defecto
if (isset($_FILES['imagenMascota']) && $_FILES['imagenMascota']['error'] === UPLOAD_ERR_OK) {
    $directorioFisico  = $_SERVER['DOCUMENT_ROOT'] . "/public/res/animal_profiles/";
    $directorioPublico = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL;

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0777, true);
    }

    $nombreArchivo = 'encuentro-' . time() . '-' . basename($_FILES['imagenMascota']['name']);
    $rutaCompleta  = $directorioFisico . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagenMascota']['tmp_name'], $rutaCompleta)) {
        $rutaBD = $directorioPublico . $nombreArchivo;
    }
}

// Validación mínima
if (empty($descripcion) || empty($lugar) || empty($fechaEncuentro)) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_reportarEncuentro.php?error=missing_fields");
    exit;
}

// --- Actualizar mascota a estado Pendiente ---
$idMascota = $_GET['idMascota'] ?? ($_POST['idMascota'] ?? null);

if ($idMascota) {
    // Actualizar mascota
    $sqlUpdate = "UPDATE mascota SET status = 'Pendiente', imagen = ? WHERE idMascota = ?";
    $stmt = $conexion->prepare($sqlUpdate);
    if ($stmt === false) {
        die("Error en prepare UPDATE: " . $conexion->error);
    }
    $stmt->bind_param("si", $rutaBD, $idMascota);
    $stmt->execute();
    $stmt->close();

    // Registrar el encuentro
    $sqlInsert = "INSERT INTO perdidos 
        (Mascota_idMascota, descripcion, lugar, fecha_de_reporte, status, contactoNombre, contactoTelefono, contactoEmail) 
        VALUES (?, ?, ?, ?, 'Pendiente', ?, ?, ?)";
    $stmt2 = $conexion->prepare($sqlInsert);
    if ($stmt2 === false) {
        die("Error en prepare INSERT: " . $conexion->error);
    }
    $stmt2->bind_param(
        "issssss",
        $idMascota,
        $descripcion,
        $lugar,
        $fechaEncuentro,
        $contactoNombre,
        $contactoTelefono,
        $contactoEmail
    );
    $stmt2->execute();
    $stmt2->close();
}

// Redirigir a lista de espera
header("Location: " . PUBLIC_PAGES_URL . "pg_listaDeEspera.php?m=encuentro_reportado");
exit;

$conexion->close();
?>
