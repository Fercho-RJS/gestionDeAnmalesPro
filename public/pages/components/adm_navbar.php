<?php // require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; 
?>
<?php
//session_start();
require_once PUBLIC_PAGES_COMPONENTS . 'link-styles.php';

if (!isset($_SESSION['user']) || $_SESSION['rol'] !== 'Administrador') {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}

$pg_actual = $_SESSION['pgActual'] ?? '';
?>

<style>
  nav .nav-link {
    color: white !important;
  }
</style>

<nav class="navbar navbar-expand-lg bg-danger shadow-sm">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand ms-3" href="<?php echo BASE_URL; ?>/index.php">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" height="50" alt="Logo">
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarAdmin" aria-controls="navbarAdmin"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-2 gap-xl-4 text-center">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'dashboard' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php">
            <i class="bi bi-speedometer2 me-1"></i>Panel
          </a>
        </li>

        <!-- Gestión de usuarios -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'usuarios' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarUsuarios.php">
            <i class="bi bi-people-fill me-1"></i>Usuarios
          </a>
        </li>

        <!-- Gestión de mascotas -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'mascotas' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_gestionMascotas.php">
            <i class="bi bi-paw-fill me-1"></i>Mascotas
          </a>
        </li>

        <!-- Reportes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($pg_actual, ['reportes', 'perdidos']) ? 'active' : ''; ?>"
            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-clipboard-data me-1"></i>Reportes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesGenerales.php">Generales</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesPerdidos.php">Mascotas perdidas</a></li>
          </ul>
        </li>

        <!-- Configuración -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'configuracion' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_configuracion.php">
            <i class="bi bi-gear-fill me-1"></i>Configuración
          </a>
        </li>

        <!-- Perfil -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'perfil' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>pg_perfilUsuario.php">
            <i class="bi bi-person-circle me-1"></i><?php echo $_SESSION['nombre']; ?>
          </a>
        </li>

        <!-- Modo oscuro -->
        <!--<li>
          <button id="darkModeToggle" class="btn btn-outline-secondary rounded-circle">
            <i id="darkModeIcon" class="bi bi-sun-fill"></i>
          </button>
        </li>-->

        <!-- Logout -->
        <li>
          <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>logout.php" method="post" onsubmit="return confirmarLogout();">
            <button class="btn text-white fs-5" type="submit" aria-label="Cerrar sesión">
              <i class="bi bi-door-open-fill"></i>
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function confirmarLogout() {
    return confirm("¿Seguro que deseas cerrar sesión?");
  }
</script>