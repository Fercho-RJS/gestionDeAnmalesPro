<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; ?>

<footer class="bg-secondary-subtle mt-5 border-top">
  <div class="container py-4">
    <div class="row">
      
      <!-- Logo y nombre -->
      <div class="col-md-4 mb-3 text-center">
        <a href="<?php echo BASE_URL; ?>/index.php" class="text-decoration-none">
          <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>isotipo.png" alt="Logo Comunidad de Animales" height="50" class="">
        </a>
        <p class="small text-muted mt-2">Construyendo un espacio seguro y responsable para el cuidado de tus mascotas.</p>
      </div>

      <!-- Enlaces legales -->
      <div class="col-md-4 mb-3 text-center">
        <h6 class="fw-bold">Información Legal</h6>
        <ul class="list-unstyled small">
          <li><a class="text-muted text-decoration-none" href="<?php echo PUBLIC_PAGES_URL; ?>static/pg_about.php">Política de Privacidad</a></li>
          <li><a class="text-muted text-decoration-none" href="#">Condiciones de Uso</a></li>
          <li><a class="text-muted text-decoration-none" href="#">Aviso Legal</a></li>
        </ul>
      </div>

      <!-- Contacto y redes -->
      <div class="col-md-4 mb-3 text-center text-md-end">
        <h6 class="fw-bold">Contacto</h6>
        <p class="small text-muted mb-1"><i class="bi bi-envelope"></i> contacto@comunidadanimales.com</p>
        <p class="small text-muted mb-3"><i class="bi bi-telephone"></i> +54 9 341 123 4567</p>
        <div class="d-flex justify-content-center justify-content-md-end gap-3">
          <a href="#" class="text-muted"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="text-muted"><i class="bi bi-instagram fs-5"></i></a>
          <a href="#" class="text-muted"><i class="bi bi-twitter-x fs-5"></i></a>
        </div>
      </div>

    </div>

    <!-- Derechos reservados -->
    <div class="row mt-4">
      <div class="col text-center">
        <p class="small text-muted mb-0">
          &copy; <?php echo date("Y"); ?> Comunidad de Animales. Todos los derechos reservados.
        </p>
      </div>
    </div>
  </div>
</footer>
