<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
require_once PUBLIC_PHP_FUNCTIONS . 'logging.php';

if (!session_id()) {
    session_start();
}

// Usuario invitado fijo
$email = "guest@invitado.com";

// Buscar el usuario asociado al email
$sql = "SELECT u.idUsuario, u.rol,
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
    // Si no existe el usuario invitado, lo creamos automáticamente
    $crearPersona = $conexion->prepare("
        INSERT INTO persona (nombre, apellido, dni, email, telefono, barrio, direccion, calleAltura, localidad, provincia)
        VALUES ('Invitado', '', '00000000', ?, '', '', '', '', '', '')
    ");
    $crearPersona->bind_param("s", $email);
    $crearPersona->execute();
    $idPersona = $conexion->insert_id;
    $crearPersona->close();

    $crearUsuario = $conexion->prepare("
        INSERT INTO usuario (Persona_idPersona, rol, password, habilitado)
        VALUES (?, 'Invitado', '', 1)
    ");
    $crearUsuario->bind_param("i", $idPersona);
    $crearUsuario->execute();
    $idUsuario = $conexion->insert_id;
    $crearUsuario->close();

    // Datos de sesión básicos
    $_SESSION['idPersona']   = $idPersona;
    $_SESSION['idUsuario']   = $idUsuario;
    $_SESSION['user']        = $email;
    $_SESSION['nombre']      = "Invitado";
    $_SESSION['apellido']    = "";
    $_SESSION['rol']         = "Invitado";
    $_SESSION['dni_persona'] = "00000000";
    $_SESSION['telefono']    = "";
    $_SESSION['direccion']   = "";
    $_SESSION['calleAltura'] = "";
} else {
    // Vincular resultados si ya existe
    $stmt->bind_result(
        $idUsuario, $rol,
        $idPersona, $nombre, $apellido, $emailDb, $dniPersona,
        $telefono, $direccion, $calleAltura
    );
    $stmt->fetch();

    $_SESSION['idPersona']   = $idPersona;
    $_SESSION['idUsuario']   = $idUsuario;
    $_SESSION['user']        = $emailDb;
    $_SESSION['nombre']      = $nombre ?: "Invitado";
    $_SESSION['apellido']    = $apellido ?: "";
    $_SESSION['rol']         = $rol ?: "Invitado";
    $_SESSION['dni_persona'] = $dniPersona ?: "00000000";
    $_SESSION['telefono']    = $telefono ?: "";
    $_SESSION['direccion']   = $direccion ?: "";
    $_SESSION['calleAltura'] = $calleAltura ?: "";
}

$_SESSION['pgActual'] = "inicio";

// Registrar log DESPUÉS de tener sesión y conexión
registrarLog("Ha iniciado sesión como invitado (usuario ID: " . ($_SESSION['idUsuario'] ?? 'N/A') . ")");

// Redirigir al workspace principal
header("Location: " . PUBLIC_PAGES_URL . "pg_main_workspace.php");
exit;
