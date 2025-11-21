<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'logging.php';

if (!session_id()) {
  session_start();
}

// Construir mensaje con datos actuales de sesión
$mensaje = 'Logout ejecutado';
if (isset($_SESSION['idUsuario'])) {
  $mensaje = "El usuario ID {$_SESSION['idUsuario']} ha cerrado sesión";
  if (!empty($_SESSION['rol'])) {
    $mensaje .= " (rol: {$_SESSION['rol']})";
  }
}

// Registrar antes de destruir sesión
registrarLog($mensaje, ['origin' => 'logout.php']);

// Destruir sesión con seguridad
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();

// Redirigir
header('Location: ' . PUBLIC_PAGES_URL . 'pg_login.php');
exit;
