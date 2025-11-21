<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

$nom  = $_POST['nombre'] ?? null;
$ape  = $_POST['apellido'] ?? null;
$doc  = $_POST['documento'] ?? null;
$tdoc = $_POST['tipoDocumento'] ?? '1';
$tel  = $_POST['telefono'] ?? null;
$eml  = $_POST['email'] ?? null;
$dom  = $_POST['domicilio'] ?? null;
$doma = $_POST['domicilioAltura'] ?? null;
$pis  = $_POST['piso'] ?? null;
$dep  = $_POST['depto'] ?? null;
$bar  = $_POST['barrio'] ?? null;
$loc  = $_POST['localidad'] ?? null;
$prov = $_POST['provincia'] ?? null;
$pass = $_POST['contrasena'] ?? null;
$vpass = $_POST['validarContrasena'] ?? null;

// Validación de campos obligatorios
if (
  empty($nom) || empty($ape) || empty($doc) || empty($tdoc) ||
  empty($tel) || empty($eml) || empty($dom) || empty($doma) ||
  empty($bar) || empty($loc) || empty($prov) || empty($pass) || empty($vpass)
) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_register.php?m=402");
  exit("Faltan datos obligatorios.");
}

if ($pass !== $vpass) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_register.php?m=403");
  exit("Las contraseñas no coinciden.");
}

// 🔎 Validar duplicados de DNI y Email
$check = $conexion->prepare("SELECT idPersona FROM persona WHERE dni = ? OR email = ? LIMIT 1");
$check->bind_param("ss", $doc, $eml);
$check->execute();
$resCheck = $check->get_result();

if ($resCheck && $resCheck->num_rows > 0) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_register.php?m=409");
  exit("El DNI o el correo electrónico ya existen en la base de datos.");
}

// Insertar persona
$insertPersona = $conexion->prepare("INSERT INTO persona (
  nombre, apellido, dni, email, telefono, barrio,
  direccion, calleAltura, depto, piso, localidad, provincia
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$insertPersona) {
  exit("Error en prepare(): " . $conexion->error);
}

$insertPersona->bind_param(
  "ssssssssssss",
  $nom,
  $ape,
  $doc,
  $eml,
  $tel,
  $bar,
  $dom,
  $doma,
  $dep,
  $pis,
  $loc,
  $prov
);

if (!$insertPersona->execute()) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_register.php?m=401");
  exit("Error al registrar persona: " . $insertPersona->error);
}

$idPersona = $conexion->insert_id;

// Generar datos para usuario
$claveSegura = password_hash($pass, PASSWORD_DEFAULT);
$rol = "user";
$habilitado = 0;

// Insertar usuario asociado a la persona
$insertUsuario = $conexion->prepare("INSERT INTO usuario (
  Persona_idPersona, rol, password, habilitado
) VALUES (?, ?, ?, ?)");

if (!$insertUsuario) {
  exit("Error en prepare usuarios: " . $conexion->error);
}

$insertUsuario->bind_param(
  "issi",
  $idPersona,   // int
  $rol,         // string
  $claveSegura, // string (hash)
  $habilitado   // int
);

if (!$insertUsuario->execute()) {
  exit("Error al registrar usuario: " . $insertUsuario->error);
}

require_once PUBLIC_PHP_FUNCTIONS . 'log.php';
registrarLog("Se ha registrado un nuevo usuario.");

// Registro exitoso
header("Location: " . PUBLIC_PAGES_URL . "pg_register.php?m=201");
exit;
