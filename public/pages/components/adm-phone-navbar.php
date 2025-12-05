<?php
// com-phone-navbar-admin.php
?>

<!-- Navbar inferior SOLO visible en móviles para Administrador -->
<nav class="navbar navbar-light border-top fixed-bottom d-md-none" style="background-color:#e74c3c;">
  <div class="container-fluid justify-content-between align-items-center text-white">

    <!-- Dashboard -->
    <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php" class="nav-link text-center flex-fill text-white">
      <i class="bi bi-speedometer2 fs-4"></i><br>
      <small>Dashboard</small>
    </a>

    <!-- Usuarios -->
    <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarUsuarios.php" class="nav-link text-center flex-fill text-white">
      <i class="bi bi-people-fill fs-4"></i><br>
      <small>Usuarios</small>
    </a>

    <!-- Mascotas -->
    <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarMascotas.php" class="nav-link text-center flex-fill text-white">
      <i class="bi bi-search-heart fs-4"></i><br>
      <small>Mascotas</small>
    </a>

    <!-- Reportes (dropup) -->
    <div class="dropup text-center flex-fill">
      <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-clipboard-data fs-4"></i><br>
        <small>Reportes</small>
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesGenerales.php"><i class="bi bi-bar-chart"></i> Generales</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>admin/pg_reportesPerdidos.php"><i class="bi bi-search"></i> Perdidos</a></li>
      </ul>
    </div>

    <!-- Perfil (SweetAlert menú) -->
    <div class="text-center flex-fill">
      <a href="javascript:void(0);" class="nav-link text-white" onclick="abrirMenuPerfilAdmin();">
        <i class="bi bi-person-circle fs-4"></i><br>
        <small>Perfil</small>
      </a>
    </div>

  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
