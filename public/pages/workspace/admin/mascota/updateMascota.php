<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idMascota = $_POST['idMascota'];
  $nombre    = $_POST['nombre'];
  $categoria = $_POST['categoria'];
  $raza      = $_POST['raza'];
  $edad      = $_POST['edad'];
  $color     = $_POST['color'];
  $height    = $_POST['height'];
  $imagen    = $_POST['imagen'];
  $chipNro   = $_POST['chipNro'];
  $status    = $_POST['status'];

  $sql = "UPDATE mascota SET nombre=?, categoria=?, raza=?, edad=?, color=?, height=?, imagen=?, chipNro=?, status=?
          WHERE idMascota=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("sssisssssi", $nombre, $categoria, $raza, $edad, $color, $height, $imagen, $chipNro, $status, $idMascota);

  if ($stmt->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "admin/pg_gestionMascotas.php?m=actualizado");
    exit();
  } else {
    echo "Error al actualizar.";
  }
}
?>
