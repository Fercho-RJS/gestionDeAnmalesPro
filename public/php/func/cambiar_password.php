<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=401");
    exit("No autenticado.");
}

$idUsuario = (int)$_SESSION['idUsuario'];

// Capturar datos del formulario
$passwordActual    = $_POST['passwordActual'] ?? '';
$passwordNueva     = $_POST['passwordNueva'] ?? '';
$passwordConfirmar = $_POST['passwordConfirmar'] ?? '';

// Validaciones básicas
if ($passwordActual === '' || $passwordNueva === '' || $passwordConfirmar === '') {
    header("Location: " . PUBLIC_PAGES_URL . "pg_perfilUsuario.php?error=faltan_datos");
    exit;
}

if ($passwordNueva !== $passwordConfirmar) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_perfilUsuario.php?error=confirmacion_incorrecta");
    exit;
}

// Buscar contraseña actual en la BD
$sql = "SELECT password FROM usuario WHERE idUsuario = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$stmt->bind_result($hashPassword);
$stmt->fetch();
$stmt->close();

// Verificar contraseña actual
if (!password_verify($passwordActual, $hashPassword)) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_perfilUsuario.php?error=password_actual_incorrecta");
    exit;
}

// Generar hash de la nueva contraseña
$nuevoHash = password_hash($passwordNueva, PASSWORD_DEFAULT);

// Actualizar contraseña en la BD
$conexion->begin_transaction();

try {
    $sqlUpdate = "UPDATE usuario SET password = ? WHERE idUsuario = ?";
    $stmt = $conexion->prepare($sqlUpdate);
    $stmt->bind_param("si", $nuevoHash, $idUsuario);
    $stmt->execute();
    $stmt->close();

    $conexion->commit();

    header("Location: " . PUBLIC_PAGES_URL . "pg_perfilUsuario.php?m=password_actualizada");
    exit;

} catch (Throwable $e) {
    $conexion->rollback();
    error_log("Error cambiar_password: " . $e->getMessage());
    header("Location: " . PUBLIC_PAGES_URL . "pg_perfilUsuario.php?error=500");
    exit("Error interno: " . $e->getMessage());
} finally {
    if ($conexion && $conexion->ping()) {
        $conexion->close();
    }
}
