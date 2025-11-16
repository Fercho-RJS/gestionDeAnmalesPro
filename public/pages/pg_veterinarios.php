<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veterinarios | Comunidad de Animales</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-veterinarios.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</head>

<body id="ContenedorGeneral">
  <?php require PUBLIC_PAGES_COMPONENTS . 'marquee.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'header.php'; ?>

  <section class="container my-5">
    <div class="text-center mb-4">
      <h1 class="fw-bold">Directorio de Veterinarios</h1>
      <p class="text-muted">Encuentra clínicas y profesionales disponibles en San Cristóbal, Santa Fe</p>
    </div>

    <div class="row g-4">
      <!-- Veterinaria La Herradura -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo PUBLIC_RESOURCES_CARDS_URL; ?>vet-h.png" class="card-img-top rounded-top" alt="Veterinaria La Herradura">
          <div class="card-body">
            <h5 class="card-title">Veterinaria "La Herradura"</h5>
            <p class="card-text small text-muted">Belgrano 1570<br>S3070 San Cristóbal<br>Santa Fe</p>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> Contactar</a>
              <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle"></i> SOS</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Veterinaria Pierantoni -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo PUBLIC_RESOURCES_CARDS_URL; ?>vet-pierantoni.png" class="card-img-top rounded-top" alt="Veterinaria Pierantoni">
          <div class="card-body">
            <h5 class="card-title">Veterinaria "Pierantoni"</h5>
            <p class="card-text small text-muted">Belgrano 740<br>S3070 San Cristóbal<br>Santa Fe</p>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> Contactar</a>
              <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle"></i> SOS</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Veterinaria Tierra Gaucha -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo PUBLIC_RESOURCES_CARDS_URL; ?>default.png" class="card-img-top rounded-top" alt="Veterinaria Tierra Gaucha">
          <div class="card-body">
            <h5 class="card-title">Veterinaria "Tierra Gaucha"</h5>
            <p class="card-text small text-muted">Caseros 1136<br>S3070 San Cristóbal<br>Santa Fe</p>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> Contactar</a>
              <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle"></i> SOS</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Veterinaria Porcel de Peralta -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo PUBLIC_RESOURCES_CARDS_URL; ?>default.png" class="card-img-top rounded-top" alt="Veterinaria Porcel de Peralta">
          <div class="card-body">
            <h5 class="card-title">Vet. "Porcel de Peralta"</h5>
            <p class="card-text small text-muted">Sarmiento 1014<br>S3070 San Cristóbal<br>Santa Fe</p>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> Contactar</a>
              <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle"></i> SOS</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Veterinaria Huellas -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo PUBLIC_RESOURCES_CARDS_URL; ?>default.png" class="card-img-top rounded-top" alt="Veterinaria Huellas">
          <div class="card-body">
            <h5 class="card-title">Veterinaria "Huellas"</h5>
            <p class="card-text small text-muted">Bv. San Martín & Esq. Güemes<br>S3070 San Cristóbal<br>Santa Fe</p>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> Contactar</a>
              <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle"></i> SOS</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>

</body>

</html>