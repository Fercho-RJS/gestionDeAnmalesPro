<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
  exit("ID no proporcionado.");
}

$sql = "SELECT * FROM mascota WHERE idMascota = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  exit("Mascota no encontrada.");
}

$mascota = $result->fetch_assoc();
?>

<!-- HTML para mostrar los datos -->
<h2><?php echo htmlspecialchars($mascota['nombre']); ?></h2>
<p>Raza: <?php echo htmlspecialchars($mascota['raza']); ?></p>
<p>Estado: <?php echo htmlspecialchars($mascota['status']); ?></p>
<!-- Agregá más campos según necesites -->
