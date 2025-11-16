<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// Solo administradores pueden acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso denegado.");
}

$idUsuario = (int)($_POST['idUsuario'] ?? 0);
$habilitado = (int)($_POST['habilitado'] ?? 0);

if ($idUsuario > 0) {
  $stmt = $conexion->prepare("UPDATE usuario SET habilitado = ? WHERE idUsuario = ?");
  $stmt->bind_param("ii", $habilitado, $idUsuario);
  $stmt->execute();
  $stmt->close();
}

// Redirigir de nuevo al listado
header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=200");
exit;
