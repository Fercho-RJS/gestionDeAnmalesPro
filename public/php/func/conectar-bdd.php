<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --------------- Real host ---------------
// $host = "sql106.infinityfree.com";
// $usuario = "if0_40409363";
// $contrasena = "escuelanet40";
// $baseDeDatos = "if0_40409363_refugio_db";

// --------------- Test host ---------------
$host = "localhost";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "asd";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $baseDeDatos);

// Verificar conexión
if ($conexion->connect_errno) {
    die("Error de conexión ({$conexion->connect_errno}): {$conexion->connect_error}");
}

// Establecer charset
$conexion->set_charset("utf8mb4");