<?php
// com-phone-navbar.php
?>

<!-- Navbar inferior solo visible en móviles -->
<nav class="navbar navbar-light bg-light border-top fixed-bottom d-md-none">
  <div class="container-fluid justify-content-between align-items-center">

    <!-- Inicio -->
    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_main_workspace.php" class="nav-link text-center flex-fill">
      <i class="bi bi-house-door-fill fs-4"></i><br>
      <small>Inicio</small>
    </a>

    <!-- Comunidad (dropdown) -->
    <div class="dropup text-center flex-fill">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-people-fill fs-4"></i><br>
        <small>Comunidad</small>
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php"><i class="bi bi-search"></i> Pérdidas</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesEnAdopcion.php"><i class="bi bi-heart-fill"></i> Adopciones</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_tienda.php"><i class="bi bi-bag"></i> Tienda</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_listaDeEspera.php"><i class="bi bi-clock-history"></i> Lista de espera</a></li>
      </ul>
    </div>

    <!-- Botón central flotante para Reportar -->
    <div class="position-relative flex-fill text-center">
      <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportarExtraviado.php"
        class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center"
        style="width:70px; height:70px; margin-top:-35px; border:4px solid #fff;">
        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
      </a>
      <div><small class="text-danger fw-bold">Reportar</small></div>
    </div>

    <!-- Autogestión (dropdown) -->
    <div class="dropup text-center flex-fill">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-tools fs-4"></i><br>
        <small>Autogestión</small>
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_vacunasMascota.php"><i class="bi bi-capsule"></i> Vacunaciones</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_turnosVeterinario.php"><i class="bi bi-calendar-check"></i> Asistencia</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_historialMedico.php"><i class="bi bi-file-medical"></i> Historial médico</a></li>
        <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_veterinarios.php"><i class="bi bi-hospital"></i> Veterinarios</a></li>
      </ul>
    </div>

    <!-- Perfil con SweetAlert -->
    <div class="text-center flex-fill">
      <a href="javascript:void(0);" class="nav-link" onclick="abrirMenuPerfil();">
        <i class="bi bi-person-circle fs-4"></i><br>
        <small>Perfil</small>
      </a>
    </div>

    <script>
      function abrirMenuPerfil() {
        let opciones = `
    <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_perfilUsuario.php" class="btn btn-outline-primary w-100 mb-2">
      <i class="bi bi-person"></i> Mi perfil
    </a>
  `;

        <?php if ($_SESSION['rol'] === 'Administrador' || $_SESSION['rol'] === 'Ayudante') : ?>
          opciones += `
      <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php" class="btn btn-outline-danger w-100 mb-2">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
    `;
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'Publicista') : ?>
          opciones += `
      <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_eventos.php" class="btn btn-outline-primary w-100 mb-2">
        <i class="bi bi-calendar-event"></i> Panel de eventos
      </a>
    `;
        <?php endif; ?>

        opciones += `
    <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>logout.php" method="post" onsubmit="return confirm('¿Seguro que deseas cerrar sesión?');">
      <button type="submit" class="btn btn-outline-dark w-100">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </button>
    </form>
  `;

        Swal.fire({
          title: 'Opciones de perfil',
          html: opciones,
          showConfirmButton: false,
          showCloseButton: true,
          focusConfirm: false,
          width: 350
        });
      }
    </script>



  </div>
</nav>