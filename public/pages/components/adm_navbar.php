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
  /* Navbar personalizada para Admin */
  .navbar-admin {
    background-color: #e74c3c !important; /* rojo adaptable */
  }
  .navbar-admin .nav-link {
    color: #fff !important;
  }
  .navbar-admin .nav-link.active {
    font-weight: bold;
    text-decoration: underline;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-admin shadow-sm d-none d-md-flex">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand ms-3" href="<?php echo BASE_URL; ?>/index.php">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" height="50" alt="Logo">
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarAdmin" aria-controls="navbarAdmin"
      aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-2"></i>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-3 text-center">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'dashboard' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php">
            <i class="bi bi-speedometer2 fs-3"></i>
          </a>
        </li>

        <!-- Gestión de usuarios -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'usuarios' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarUsuarios.php">
            <i class="bi bi-people-fill fs-3"></i>
          </a>
        </li>

        <!-- Gestión de mascotas -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'mascotas' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarMascotas.php">
            <i class="bi bi-search-heart fs-3"></i>
          </a>
        </li>

        <!-- Reportes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($pg_actual, ['reportes', 'perdidos']) ? 'active' : ''; ?>"
            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-clipboard-data fs-3"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesGenerales.php"><i class="bi bi-bar-chart"></i> Generales</a></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesPerdidos.php"><i class="bi bi-search"></i> Mascotas perdidas</a></li>
          </ul>
        </li>

        <!-- Configuración -->
        <li class="nav-item">
          <a class="nav-link <?php echo $pg_actual === 'configuracion' ? 'active' : ''; ?>"
            href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_configuracion.php">
            <i class="bi bi-gear-fill fs-3"></i>
          </a>
        </li>

        <!-- Perfil con SweetAlert -->
        <li class="nav-item">
          <a href="javascript:void(0);" class="nav-link <?php echo $pg_actual === 'perfil' ? 'active' : ''; ?>" onclick="abrirMenuPerfilAdmin();">
            <i class="bi bi-person-circle fs-3"></i>
          </a>
        </li>

        <!-- Logout directo (opcional, ya está en el menú) -->
        <li class="nav-item d-none d-lg-block">
          <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>logout.php" method="post"
            onsubmit="return confirmarLogout();" class="d-inline">
            <button class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
              type="submit" aria-label="Cerrar sesión" style="width:45px; height:45px;">
              <i class="bi bi-box-arrow-right fs-4"></i>
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
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" height="50" alt="Logo">
    </a>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmarLogout() {
    return confirm("¿Seguro que deseas cerrar sesión?");
  }

  function abrirMenuPerfilAdmin() {
    let opciones = `
      <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_perfilUsuario.php" class="btn btn-outline-light w-100 mb-2">
        <i class="bi bi-person"></i> Mi perfil
      </a>
      <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php" class="btn btn-outline-light w-100 mb-2">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>logout.php" method="post" onsubmit="return confirm('¿Seguro que deseas cerrar sesión?');">
        <button type="submit" class="btn btn-outline-danger w-100">
          <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </button>
      </form>
    `;

    Swal.fire({
      title: 'Opciones de administrador',
      html: opciones,
      showConfirmButton: false,
      showCloseButton: true,
      focusConfirm: false,
      background: '#e74c3c',
      color: '#fff',
      width: 350
    });
  }
</script>
