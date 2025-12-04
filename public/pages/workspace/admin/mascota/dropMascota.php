<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idMascota = $_POST['idMascota'];

  $sql = "DELETE FROM mascota WHERE idMascota = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $idMascota);

  if ($stmt->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "workspace/admin/admin_listarMascotas.php?m=eliminado");
    exit();
  } else {
    echo "Error al eliminar.";
  }
}
?>
