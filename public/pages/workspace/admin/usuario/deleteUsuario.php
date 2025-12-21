<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

session_start();

// Validar que sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
    exit("Acceso denegado.");
}

// Validar que venga el idUsuario
if (!isset($_POST['idUsuario']) || empty($_POST['idUsuario'])) {
    header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=error");
    exit("ID de usuario inválido.");
}

$idUsuario = intval($_POST['idUsuario']);

// Primero eliminar el usuario
$sql = "DELETE FROM usuario WHERE idUsuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);

if ($stmt->execute()) {
    // Opcional: eliminar también la persona asociada
    // $sqlPersona = "DELETE FROM persona WHERE idPersona = ?";
    // $stmtPersona = $conexion->prepare($sqlPersona);
    // $stmtPersona->bind_param("i", $idPersona);
    // $stmtPersona->execute();

    header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=deleted");
    exit();
} else {
    header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=error");
    exit("Error al eliminar usuario.");
}
