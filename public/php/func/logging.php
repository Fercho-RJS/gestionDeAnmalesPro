<?php
// public/php/functions/log.php

// Habilitar reporte de errores de MySQLi (opcional en producción)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Registra un evento en la tabla log_acciones. Si falla la base, lo guarda en error_log.
 *
 * @param string $accion Mensaje de la acción realizada
 * @param array $extra   Datos extra opcionales: ['context' => '...', 'tag' => '...']
 * @return bool         true si se insertó en BDD, false si se usó fallback
 */
function registrarLog(string $accion, array $extra = []): bool {
  // Rutas y conexión
  if (!defined('PUBLIC_PHP_FUNCTIONS')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
  }

  // Asegurar conexión activa ($conexion) disponible
  if (!isset($GLOBALS['conexion']) || !($GLOBALS['conexion'] instanceof mysqli)) {
    require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
  }
  $conexion = $GLOBALS['conexion'] ?? null;

  // Captura de contexto
  if (!session_id()) {
    session_start();
  }
  $usuario_id = $_SESSION['idUsuario'] ?? null;
  $rol        = $_SESSION['rol'] ?? null;
  $ip         = $_SERVER['REMOTE_ADDR'] ?? null;
  $ua         = $_SERVER['HTTP_USER_AGENT'] ?? null;

  // Agregar info extra en JSON si llega
  $contexto = !empty($extra) ? (' | extra=' . json_encode($extra, JSON_UNESCAPED_UNICODE)) : '';

  try {
    if (!($conexion instanceof mysqli)) {
      throw new Exception('Conexión BDD no disponible');
    }

    // Inserción
    $sql = "INSERT INTO log_acciones (usuario_id, rol, accion, ip_origen, user_agent) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
      throw new Exception('Prepare falló: ' . $conexion->error);
    }
    $accionFinal = $accion . $contexto;
    $stmt->bind_param("issss", $usuario_id, $rol, $accionFinal, $ip, $ua);
    $stmt->execute();
    $stmt->close();
    return true;

  } catch (Throwable $e) {
    // Fallback a archivo de log del servidor
    error_log('[LOG_FALLBACK] ' . $accion . $contexto . ' | error=' . $e->getMessage());
    return false;
  }
}
