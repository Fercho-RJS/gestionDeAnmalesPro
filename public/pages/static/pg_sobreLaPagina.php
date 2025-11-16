<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nosotros - Comunidad de Animales</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body>
  <?php require PUBLIC_PAGES_COMPONENTS . 'navbar.php'; ?>

  <section class="container my-5">
    <div class="text-center mb-4">
      <h1 class="fw-bold">Comunidad de Animales</h1>
      <p class="lead text-muted">Un refugio digital para proteger, encontrar y cuidar a nuestras mascotas.</p>
    </div>

    <!-- Misión -->
    <div class="row mb-5">
      <div class="col-md-6">
        <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>refugio.jpg" alt="Refugio digital" class="img-fluid rounded shadow-sm">
      </div>
      <div class="col-md-6 d-flex flex-column justify-content-center">
        <h3 class="fw-bold">Nuestra Misión</h3>
        <p class="text-muted">
          Somos un espacio digital creado para unir a las personas con sus mascotas.
          Nuestra finalidad es ofrecer un refugio virtual donde cada animal tenga visibilidad,
          y donde cada dueño pueda encontrar apoyo en casos de extravío, adopción o cuidado.
        </p>
      </div>
    </div>

    <!-- Funcionalidades -->
    <div class="row mb-5">
      <div class="col-md-6 d-flex flex-column justify-content-center">
        <h3 class="fw-bold">¿Qué ofrecemos?</h3>
        <ul class="list-unstyled text-muted">
          <li><i class="bi bi-search"></i> Búsqueda de animales perdidos con filtros por zona y características.</li>
          <li><i class="bi bi-heart"></i> Espacios para promover adopciones responsables.</li>
          <li><i class="bi bi-shop"></i> Tienda solidaria con productos para el cuidado de mascotas.</li>
          <li><i class="bi bi-hospital"></i> Directorio de veterinarios y servicios de salud animal.</li>
        </ul>
      </div>
      <div class="col-md-6">
        <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>animales.jpg" alt="Animales felices" class="img-fluid rounded shadow-sm">
      </div>
    </div>

    <!-- Compromiso -->
    <div class="text-center">
      <h3 class="fw-bold">Nuestro Compromiso</h3>
      <p class="text-muted">
        Creemos en una comunidad solidaria, donde cada mascota cuenta y cada persona puede aportar.
        Este refugio digital es más que una página web: es un puente entre quienes buscan, quienes ayudan
        y quienes desean dar una segunda oportunidad a los animales.
      </p>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</body>

</html>