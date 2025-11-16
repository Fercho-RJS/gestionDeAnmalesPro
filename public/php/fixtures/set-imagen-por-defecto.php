<?php
// Conexión a la BDD
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

// Definir la ruta de la imagen por defecto usando constantes
$imagenDefecto = PUBLIC_RESOURCES_IMAGES_URL . "animal.png";

// Actualizar mascotas con rutas de perfil inválidas o antiguas
$sql = "UPDATE mascota 
        SET imagen = ? 
        WHERE imagen IS NULL 
          AND (imagen LIKE '%/animal_profile/cat-%' OR imagen LIKE '%/animal_profile/dog-%')";

$stmt = $conexion->prepare($sql);

if ($stmt) {
  $stmt->bind_param("s", $imagenDefecto);
  if ($stmt->execute()) {
    echo "Actualización realizada correctamente.";
  } else {
    die("Error al ejecutar la consulta: " . $stmt->error);
  }
  $stmt->close();
} else {
  die("Error en la preparación de la consulta: " . $conexion->error);
}

mysqli_close($conexion);
