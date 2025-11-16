<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

$email = $_POST['usuario'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || empty($password)) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?error=faltan_datos");
    exit;
}

// Buscar el usuario asociado al email
$sql = "SELECT u.idUsuario, u.password, u.rol, u.habilitado,
               p.idPersona, p.nombre, p.apellido, p.email, p.dni AS dni_persona,
               p.telefono, p.direccion, p.calleAltura
        FROM usuario u
        INNER JOIN persona p ON p.idPersona = u.Persona_idPersona
        WHERE p.email = ? LIMIT 1";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    exit("Error en prepare: " . $conexion->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?error=usuario_no_existe");
    exit;
}

// Vincular resultados
$stmt->bind_result(
    $idUsuario, $hashPassword, $rol, $habilitado,
    $idPersona, $nombre, $apellido, $emailDb, $dniPersona,
    $telefono, $direccion, $calleAltura
);
$stmt->fetch();

// Verificar habilitado
if ((int)$habilitado !== 1) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?error=usuario_no_habilitado");
    exit;
}

// Verificar contraseña
if (!password_verify($password, $hashPassword)) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?error=password_incorrecta");
    exit;
}

// Si llega acá → login correcto
$_SESSION['idPersona']   = $idPersona;
$_SESSION['idUsuario']   = $idUsuario;
$_SESSION['user']        = $emailDb;
$_SESSION['nombre']      = $nombre;
$_SESSION['apellido']    = $apellido;
$_SESSION['rol']         = $rol;
$_SESSION['dni_persona'] = $dniPersona;
$_SESSION['telefono']    = $telefono;
$_SESSION['direccion']   = $direccion;
$_SESSION['calleAltura'] = $calleAltura;

$_SESSION['pgActual'] = "inicio";

// Redirigir al workspace principal
header("Location: " . PUBLIC_PAGES_URL . "pg_main_workspace.php");
exit;
