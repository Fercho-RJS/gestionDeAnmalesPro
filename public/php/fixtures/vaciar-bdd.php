<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

// Desactivar claves foráneas, vaciar tablas y reactivar
$sql = "
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE TABLE perdidos;
    TRUNCATE TABLE mascota;
    SET FOREIGN_KEY_CHECKS = 1;
";

if ($conexion->multi_query($sql)) {
  echo "Base de datos vaciada correctamente.";
} else {
  echo "Error al vaciar la base de datos: " . $conexion->error;
}

$conexion->close();
