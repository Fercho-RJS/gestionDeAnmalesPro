<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

// Verificar sesión y permisos básicos
if (!isset($_SESSION['rol']) || !isset($_SESSION['idUsuario'])) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=401");
  exit("No autenticado.");
}

// Leer y validar parámetros
$idMascota = isset($_GET['idMascota']) ? (int)$_GET['idMascota'] : 0;
$nuevoEstado = $_GET['nuevoEstado'] ?? '';

$estadosPermitidos = ['Adoptado', 'Perdido', 'En adopción'];

if ($idMascota <= 0 || !in_array($nuevoEstado, $estadosPermitidos, true)) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=402");
  exit("Parámetros inválidos.");
}

// Verificar que la mascota pertenece al usuario
$verificar = $conexion->prepare("
  SELECT idMascota FROM mascota 
  WHERE idMascota = ? AND Usuario_idUsuario = ?
  LIMIT 1
");
$verificar->bind_param("ii", $idMascota, $_SESSION['idUsuario']);
$verificar->execute();
$verificar->store_result();
if ($verificar->num_rows === 0) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=404");
  exit("Mascota no encontrada o no te pertenece.");
}
$verificar->close();

// Actualizar estado en tabla mascota
$update = $conexion->prepare("UPDATE mascota SET status = ? WHERE idMascota = ?");
$update->bind_param("si", $nuevoEstado, $idMascota);
if (!$update->execute()) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=401");
  exit("Error al actualizar estado.");
}
$update->close();

// Si el nuevo estado es 'Perdido', registrar en tabla perdidos si no existe
if ($nuevoEstado === 'Perdido') {
  $existe = $conexion->prepare("
    SELECT Mascota_idMascota FROM perdidos 
    WHERE Mascota_idMascota = ? AND status = 'Perdido'
    LIMIT 1
  ");
  $existe->bind_param("i", $idMascota);
  $existe->execute();
  $existe->store_result();

  if ($existe->num_rows === 0) {
    $existe->close();

    $insert = $conexion->prepare("
      INSERT INTO perdidos (Mascota_idMascota, status) 
      VALUES (?, 'Perdido')
    ");
    $insert->bind_param("i", $idMascota);
    if (!$insert->execute()) {
      header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=405");
      exit("Error al registrar en perdidos.");
    }
    $insert->close();
  } else {
    $existe->close();
  }
}

// Si el nuevo estado es 'Adoptado' o 'En adopción', eliminar de perdidos si existe
if (in_array($nuevoEstado, ['Adoptado', 'En adopción'], true)) {
  $delete = $conexion->prepare("
    DELETE FROM perdidos 
    WHERE Mascota_idMascota = ? AND status = 'Perdido'
  ");
  $delete->bind_param("i", $idMascota);
  $delete->execute(); // no importa si no existe, no genera error
  $delete->close();
}

// Redirigir con éxito
header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=201");
exit;
