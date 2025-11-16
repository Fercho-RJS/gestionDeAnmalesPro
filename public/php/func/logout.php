<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();

// Limpiar y destruir la sesión
session_unset();
session_destroy();

// Redirigir al login
header("Location: " . PUBLIC_PAGES_URL . "pg_login.php");
exit;
