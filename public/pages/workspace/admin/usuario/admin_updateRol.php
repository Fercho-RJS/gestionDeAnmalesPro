<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// Solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso denegado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idUsuario = (int)$_POST['idUsuario'];
  $rol       = $_POST['rol'];

  // Validar rol permitido
  $rolesPermitidos = ["Administrador", "Ayudante", "Veterinario", "Usuario", "Publicista", "Invitado"];
  if (!in_array($rol, $rolesPermitidos)) {
    die("Rol inválido.");
  }

  $sql = "UPDATE usuario SET rol = ? WHERE idUsuario = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("si", $rol, $idUsuario);

  if ($stmt->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarUsuarios.php?m=rol_actualizado");
    exit();
  } else {
    die("Error al actualizar rol: " . $stmt->error);
  }
}
?>
