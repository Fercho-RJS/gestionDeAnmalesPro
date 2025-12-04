<?php
// com-phone-navbar.php
?>

<!-- Navbar inferior solo visible en móviles -->
<nav class="navbar navbar-light bg-light border-top fixed-bottom d-md-none">
  <div class="container-fluid justify-content-around">

    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_main_workspace.php" class="nav-link text-center">
      <i class="bi bi-house-door-fill fs-4"></i><br>
      <small>Inicio</small>
    </a>

    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php" class="nav-link text-center">
      <i class="bi bi-search-heart fs-4"></i><br>
      <small>Perdidos</small>
    </a>

    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportarExtraviado.php" class="nav-link text-center">
      <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i><br>
      <small>Reportar</small>
    </a>

    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesEnAdopcion.php" class="nav-link text-center">
      <i class="bi bi-heart-fill fs-4 text-success"></i><br>
      <small>Adopciones</small>
    </a>

    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_perfilUsuario.php" class="nav-link text-center">
      <i class="bi bi-person-circle fs-4"></i><br>
      <small>Perfil</small>
    </a>

  </div>
</nav>
