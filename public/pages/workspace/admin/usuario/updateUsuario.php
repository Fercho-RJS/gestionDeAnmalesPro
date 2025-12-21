<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// Validar que sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
    exit("Acceso denegado.");
}

$idUsuario = intval($_POST['idUsuario']);
$nombre    = $_POST['nombre'];
$apellido  = $_POST['apellido'];
$email     = $_POST['email'];
$dni       = $_POST['dni'];
$rol       = $_POST['rol'];
$habilitado= intval($_POST['habilitado']);

// Si se pidió resetear contraseña
$passwordHash = null;
if (!empty($_POST['password'])) {
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
} elseif (isset($_POST['resetPassword']) && $_POST['resetPassword'] == 1) {
    // Clave temporal, por ejemplo "123456"
    $passwordHash = password_hash("123456", PASSWORD_DEFAULT);
}

// Update persona
$sqlPersona = "UPDATE persona SET nombre=?, apellido=?, email=?, dni=? 
               WHERE idPersona = (SELECT Persona_idPersona FROM usuario WHERE idUsuario=?)";
$stmtPersona = $conexion->prepare($sqlPersona);
$stmtPersona->bind_param("ssssi", $nombre, $apellido, $email, $dni, $idUsuario);
$stmtPersona->execute();

// Update usuario
if ($passwordHash) {
    $sqlUsuario = "UPDATE usuario SET rol=?, habilitado=?, password=? WHERE idUsuario=?";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bind_param("sisi", $rol, $habilitado, $passwordHash, $idUsuario);
} else {
    $sqlUsuario = "UPDATE usuario SET rol=?, habilitado=? WHERE idUsuario=?";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bind_param("sii", $rol, $habilitado, $idUsuario);
}
$stmtUsuario->execute();

header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=updated");
exit();
