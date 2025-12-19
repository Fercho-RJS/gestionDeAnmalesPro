<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'logging.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar sesión
if (!isset($_SESSION['idPersona']) || !isset($_SESSION['idUsuario'])) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=401");
    exit("No autenticado.");
}

$idPersona  = (int)$_SESSION['idPersona'];
$idUsuario  = (int)$_SESSION['idUsuario'];

// Captura de datos del formulario
$dni         = trim($_POST['dni'] ?? '');
$nombre      = trim($_POST['nombre'] ?? '');
$apellido    = trim($_POST['apellido'] ?? '');
$email       = trim($_POST['email'] ?? '');
$telefono    = trim($_POST['telefono'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$calleAltura = trim($_POST['calleAltura'] ?? '');

// Validación mínima
if ($dni === '' || $nombre === '' || $apellido === '' || $email === '') {
    header("Location: " . PUBLIC_PAGES_URL . "pg_perfil.php?m=missing_fields");
    exit("Campos obligatorios faltantes.");
}

// Procesar foto de perfil
$fotoPerfilRuta = $_SESSION['fotoPerfil'] ?? (PUBLIC_RESOURCES_URL . "user_profiles/defaultuser.png");

if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
    $directorioFisico  = $_SERVER['DOCUMENT_ROOT'] . "/public/res/user_profiles/";
    $directorioPublico = PUBLIC_RESOURCES_URL . "user_profiles/";

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0777, true);
    }

    $nombreArchivo = 'user-' . $idUsuario . '-' . time() . '-' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES['fotoPerfil']['name']));
    $rutaCompleta  = $directorioFisico . $nombreArchivo;

    if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $rutaCompleta)) {
        $fotoPerfilRuta = $directorioPublico . $nombreArchivo;
    }
}

// Actualizar en la base de datos
$conexion->begin_transaction();

try {
    // 1. Actualizar datos en persona
    $sqlPersona = "UPDATE persona 
                   SET dni = ?, nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, calleAltura = ?
                   WHERE idPersona = ?";
    $stmt1 = $conexion->prepare($sqlPersona);
    $stmt1->bind_param("sssssssi", $dni, $nombre, $apellido, $email, $telefono, $direccion, $calleAltura, $idPersona);
    $stmt1->execute();
    $stmt1->close();

    // 2. Actualizar foto en usuario
    $sqlUsuario = "UPDATE usuario SET photo = ? WHERE idUsuario = ?";
    $stmt2 = $conexion->prepare($sqlUsuario);
    $stmt2->bind_param("si", $fotoPerfilRuta, $idUsuario);
    $stmt2->execute();
    $stmt2->close();

    $conexion->commit();

    // Actualizar sesión
    $_SESSION['dni_persona'] = $dni;
    $_SESSION['nombre']      = $nombre;
    $_SESSION['apellido']    = $apellido;
    $_SESSION['user']        = $email;
    $_SESSION['telefono']    = $telefono;
    $_SESSION['direccion']   = $direccion;
    $_SESSION['calleAltura'] = $calleAltura;
    $_SESSION['fotoPerfil']  = $fotoPerfilRuta;

    header("Location: " . PUBLIC_PAGES_URL . "pg_main_workspace.php?m=perfil_actualizado");
    registrarLog("Usuario editó perfil");
    exit();

} catch (Throwable $e) {
    $conexion->rollback();
    error_log("Error actualizar_perfil: " . $e->getMessage());
    header("Location: " . PUBLIC_PAGES_URL . "pg_main_workspace.php?m=500");
    exit("Error interno: " . $e->getMessage());
} finally {
    if ($conexion && $conexion->ping()) {
        $conexion->close();
    }
}


