<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-index.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
</head>

<body>
  <!-- Fondo animado + overlay -->
  <div class="bg-cover"></div>
  <div class="bg-overlay"></div>

  <section id="ContenedorGeneral" class="page-content">
    <?php require PUBLIC_PAGES_COMPONENTS . 'marquee.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'header.php'; ?>

    <section id="cuerpo-de-la-web">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>bannerindex.png" class="img-fluid" alt="">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>bannerindex2.png" class="img-fluid mt-5" alt="">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>bannerindex3.png" class="img-fluid mt-5" alt="">
      <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>bannerindex4.png" class="img-fluid mt-5" alt="">

      <div class="row d-flex justify-content-center">
        <div class="col-auto">
          <p><i class="bi bi-instagram fs-1 mt-5"></i></p>
        </div>
        <div class="col-auto">
          <p><i class="bi bi-facebook fs-1 mt-5"></i></p>
        </div>
        <div class="col-auto">
          <p><i class="bi bi-youtube fs-1 mt-5"></i></p>
        </div>
        <div class="col-auto">
          <p><i class="bi bi-envelope fs-1 mt-5"></i></p>
        </div>
      </div>
    </section>

    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  </section>
</body>

</html>