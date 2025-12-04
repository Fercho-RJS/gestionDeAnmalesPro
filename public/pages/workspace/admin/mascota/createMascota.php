<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario_id = $_POST['usuario_id'] ?? null;
  $nombre     = $_POST['nombre'] ?? '';
  $categoria  = $_POST['categoria'] ?? '';
  $raza       = $_POST['raza'] ?? '';
  $edad       = $_POST['edad'] ?? null;
  $color      = $_POST['color'] ?? '';
  $height     = $_POST['height'] ?? '';
  $imagen     = $_POST['imagen'] ?? '';
  $chipNro    = $_POST['chipNro'] ?? '';
  $status     = $_POST['status'] ?? 'Activo';

  $sql = "INSERT INTO mascota (Usuario_idUsuario, nombre, categoria, raza, edad, color, height, imagen, chipNro, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("isssisssss", $usuario_id, $nombre, $categoria, $raza, $edad, $color, $height, $imagen, $chipNro, $status);

  if ($stmt->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "admin/pg_gestionMascotas.php?m=creado");
    exit();
  } else {
    echo "Error al crear mascota.";
  }
}
?>
