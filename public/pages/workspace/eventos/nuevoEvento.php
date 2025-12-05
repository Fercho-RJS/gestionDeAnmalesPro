<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Roles permitidos
$rolesPermitidos = ['Publicista', 'Administrador', 'Ayudante'];
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso no autorizado.");
}

// Captura de datos del formulario
$titulo        = trim($_POST['titulo'] ?? '');
$fecha_inicio  = $_POST['fecha_inicio'] ?? null;
$fecha_fin     = $_POST['fecha_fin'] ?? null;
$hora_inicio   = $_POST['hora_inicio'] ?? null;
$descripcion   = trim($_POST['descripcion'] ?? '');
$estado        = $_POST['estado'] ?? 'Pendiente';
$idUsuario     = $_SESSION['idUsuario'] ?? null;

// Imagen portada
$rutaBD = null;
if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] === UPLOAD_ERR_OK) {
    $directorioFisico  = $_SERVER['DOCUMENT_ROOT'] . "/public/res/eventos/";
    $directorioPublico = PUBLIC_RESOURCES_URL . "eventos/";

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0777, true);
    }

    $nombreArchivo = 'evento-' . time() . '-' . basename($_FILES['imagen_portada']['name']);
    $rutaCompleta  = $directorioFisico . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagen_portada']['tmp_name'], $rutaCompleta)) {
        $rutaBD = $directorioPublico . $nombreArchivo;
    }
}

// Validación mínima
if (empty($titulo) || empty($fecha_inicio) || empty($fecha_fin) || empty($descripcion)) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_eventos.php?m=missing_fields");
    exit;
}

// Insertar evento
$sql = "INSERT INTO eventos 
        (Usuario_idUsuario, titulo, fecha_inicio, fecha_fin, hora_inicio, descripcion, estado, imagen_portada) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param(
    "isssssss",
    $idUsuario,
    $titulo,
    $fecha_inicio,
    $fecha_fin,
    $hora_inicio,
    $descripcion,
    $estado,
    $rutaBD
);
$stmt->execute();
$stmt->close();

$conexion->close();

// Redirigir con mensaje de éxito
header("Location: " . PUBLIC_PAGES_URL . "pg_eventos.php?m=evento_registrado");
exit;
