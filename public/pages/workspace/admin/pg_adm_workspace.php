<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "dashboard";

// Validar acceso de administrador
if (!isset($_SESSION['user']) || $_SESSION['rol'] !== 'Administrador') {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm_navbar.php'; ?>

    <section class="container my-5">
      <h1 class="fw-bold mb-4 text-center">Panel de Administración</h1>
      <hr>

      <!-- Paneles resumen -->
      <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-light">
            <h5 class="fw-bold">Usuarios registrados</h5>
            <p class="display-6 text-primary">124</p>
            <a href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_gestionUsuarios.php" class="btn btn-outline-primary btn-sm">Ver usuarios</a>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-light">
            <h5 class="fw-bold">Mascotas activas</h5>
            <p class="display-6 text-success">87</p>
            <a href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_gestionMascotas.php" class="btn btn-outline-success btn-sm">Ver mascotas</a>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-light">
            <h5 class="fw-bold">Reportes de extravío</h5>
            <p class="display-6 text-danger">15</p>
            <a href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesPerdidos.php" class="btn btn-outline-danger btn-sm">Ver reportes</a>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-light">
            <h5 class="fw-bold">Solicitudes pendientes</h5>
            <p class="display-6 text-warning">6</p>
            <a href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_configuracion.php" class="btn btn-outline-warning btn-sm">Revisar</a>
          </div>
        </div>
      </div>

      <!-- Sección de actividad reciente -->
      <div class="card shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-3">Actividad reciente</h4>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">📌 Usuario <b>lucia.mascotas</b> registró una mascota nueva.</li>
          <li class="list-group-item">📌 Se reportó una mascota perdida en <b>Santa Fe</b>.</li>
          <li class="list-group-item">📌 Usuario <b>admin</b> actualizó el estado de <b>“Toby”</b> a <span class="badge bg-success">Adoptado</span>.</li>
          <li class="list-group-item">📌 Se aprobó una solicitud de registro de <b>veterinario</b>.</li>
        </ul>
      </div>
    </section>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  </section>
</body>

</html>