<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; ?>

<nav class="navbar navbar-expand-lg bg-body-secondary shadow-sm sticky-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand ms-3 fw-bold d-flex align-items-center" href="<?php echo BASE_URL; ?>/index.php">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" height="50" alt="Logo Comunidad de Animales" class="me-2">
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
            aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-3"></i>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-2 gap-xl-4 text-center">

        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active fw-bold' : ''; ?>" 
             aria-current="page" href="<?php echo BASE_URL; ?>/index.php">
            <i class="bi bi-house-door"></i> Inicio
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo PUBLIC_PAGES_URL; ?>static/pg_sobreLaPagina.php">
            <i class="bi bi-info-circle"></i> Sobre nosotros
          </a>
        </li>

        <!-- Dropdown E-Commerce -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bag"></i> E-Commerce
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><i class="bi bi-droplet"></i> Limpieza & Cuidado</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-controller"></i> Juegos & Juguetes</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-shirt"></i> Accesorios & Ropa</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-cup-hot"></i> Alimentación</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item fw-bold" href="<?php echo PUBLIC_PAGES_URL; ?>pg_tienda.php"><i class="bi bi-shop"></i> Tienda</a></li>
          </ul>
        </li>

        <!-- Dropdown Gestiones -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-tools"></i> Gestiones
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php"><i class="bi bi-search"></i> Mascotas Perdidas</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo PUBLIC_PAGES_URL; ?>pg_veterinarios.php"><i class="bi bi-hospital"></i> Veterinarios</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link"><i class="bi bi-calendar-event"></i> Eventos</a>
        </li>

        <!-- Dark Mode -->
        <!--<li>
          <button id="darkModeToggle" class="btn btn-outline-secondary <?php echo $textColor; ?> rounded-circle" aria-label="Cambiar tema">
            <i id="darkModeIcon" class="bi bi-sun-fill"></i>
          </button>
        </li>-->

        <li class="nav-item">
          <a class="nav-link fw-bold text-success" href="<?php echo PUBLIC_PAGES_URL; ?>pg_login.php">
            <i class="bi bi-door-open"></i> Acceder al Sistema
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
