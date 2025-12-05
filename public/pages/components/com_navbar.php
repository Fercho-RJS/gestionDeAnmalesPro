<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; ?>
<?php
if (!session_id()) {
  session_start();
}
require_once PUBLIC_PAGES_COMPONENTS . 'link-styles.php';

if (!isset($_SESSION['user'])) {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}

# Color de la barra de navegación según rol.
switch ($_SESSION['rol']) {
  case 'Veterinario':
    $backgroundColor = 'bg-success-subtle';
    break;
  case 'Usuario':
    $backgroundColor = 'bg-body-secondary';
    break;
  case 'Invitado':
    $backgroundColor = 'bg-body-secondary';
    break;
  case 'Publicista':
    $backgroundColor = 'bg-primary-subtle';
    break;
  case 'Ayudante':
    $backgroundColor = 'bg-warning-subtle';
    break;
  case 'Administrador':
    $backgroundColor = 'bg-danger-subtle';
    $textColor = 'black';
    break;
}

$pg_actual = $_SESSION['pgActual'];
?>

<!-- Navbar para escritorio/tablet -->
<nav class="navbar navbar-expand-lg <?php echo $backgroundColor; ?> shadow-sm sticky-top d-none d-md-flex">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand mx-auto fw-bold" href="<?php echo BASE_URL; ?>/index.php">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" height="50" alt="Logo Comunidad de Animales">
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent3" aria-controls="navbarSupportedContent3"
      aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-2"></i>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent3">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-3 text-center">

        <!-- Inicio -->
        <li class="nav-item">
          <a class="nav-link <?php echo $textColor; ?> <?php echo $pg_actual === 'inicio' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>pg_main_workspace.php">
            <i class="bi bi-house fs-3"></i>
          </a>
        </li>

        <!-- Publicista -->
        <?php if ($_SESSION['rol'] === 'Publicista') : ?>
          <li class="nav-item dropdown">
            <a class="nav-link <?php echo $textColor; ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-megaphone fs-3"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_eventos.php"><i class="bi bi-calendar-event"></i> Eventos</a></li>
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_noticias.php"><i class="bi bi-newspaper"></i> Noticias</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Mis Mascotas -->
        <li class="nav-item">
          <a class="nav-link <?php echo $textColor; ?> <?php echo $pg_actual === 'misMascotas' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>pg_misMascotas.php">
            <i class="bi bi-heart fs-3"></i>
          </a>
        </li>

        <!-- Comunidad -->
        <li class="nav-item dropdown">
          <a class="nav-link <?php echo $textColor; ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-people fs-3"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php"><i class="bi bi-search"></i> Pérdidas</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesEnAdopcion.php"><i class="bi bi-heart"></i> Adopciones</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_tienda.php"><i class="bi bi-bag"></i> Tienda</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_listaDeEspera.php"><i class="bi bi-clock-history"></i> Lista de espera</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportarExtraviado.php"><i class="bi bi-exclamation-triangle"></i> Reportar extravío</a></li>
          </ul>
        </li>

        <!-- Autogestión -->
        <li class="nav-item dropdown">
          <a class="nav-link <?php echo $textColor; ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-tools fs-3"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_vacunasMascota.php"><i class="bi bi-capsule"></i> Vacunaciones</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_turnosVeterinario.php"><i class="bi bi-calendar-check"></i> Asistencia</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_historialMedico.php"><i class="bi bi-file-medical"></i> Historial médico</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_veterinarios.php"><i class="bi bi-hospital"></i> Veterinarios</a></li>
          </ul>
        </li>

        <!-- Veterinario -->
        <?php if ($_SESSION['rol'] === 'Veterinario') : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-shield fs-3"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>vet/pg_pacientes.php"><i class="bi bi-clipboard-heart"></i> Pacientes</a></li>
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>vet/pg_turnos.php"><i class="bi bi-calendar-event"></i> Turnos</a></li>
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>vet/pg_historial.php"><i class="bi bi-journal-medical"></i> Historial clínico</a></li>
              <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>vet/pg_informes.php"><i class="bi bi-file-earmark-text"></i> Informes</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Perfil -->
        <li class="nav-item">
          <a class="nav-link <?php echo $textColor; ?> <?php echo $pg_actual === 'perfil' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>pg_perfilUsuario.php">
            <i class="bi bi-person fs-3"></i>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>logout.php" method="post"
            onsubmit="return confirmarLogout();" class="d-inline">
            <button class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center"
              type="submit" aria-label="Cerrar sesión" style="width:45px; height:45px;">
              <i class="bi bi-box-arrow-right fs-3"></i>
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Navbar simplificada SOLO para móviles -->
<nav class="navbar navbar-light bg-white shadow-sm sticky-top d-flex d-md-none">
  <div class="container-fluid justify-content-center">
    <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>/index.php">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" 
           alt="Logo Comunidad de Animales" 
           height="50">
    </a>
  </div>
</nav>