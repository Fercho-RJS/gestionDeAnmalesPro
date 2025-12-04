<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "reportarEncuentro";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportar Encuentro de Mascota</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section id="ContenedorGeneral">
  <?php
  require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
  require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
  ?>

  <div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body p-4">
        <h1 class="mb-4 text-center text-success">
          <i class="bi bi-search-heart me-2"></i> Reportar Encuentro de Mascota
        </h1>

        <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/registrar-encuentro.php"
              method="post" enctype="multipart/form-data" class="row g-3">

          <!-- Datos de la mascota encontrada -->
          <div class="col-md-6">
            <label for="imagenMascota" class="form-label fw-bold">Foto de la mascota</label>
            <input type="file" class="form-control" id="imagenMascota" name="imagenMascota"
                   accept="image/*" required>
          </div>

          <div class="col-md-6">
            <label for="descripcion" class="form-label fw-bold">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                      placeholder="Ej: Perro mediano, collar rojo, muy dócil" required></textarea>
          </div>

          <div class="col-md-6">
            <label for="lugar" class="form-label fw-bold">Lugar del encuentro</label>
            <input type="text" class="form-control" id="lugar" name="lugar"
                   placeholder="Ej: Plaza San Martín, Santa Fe" required>
          </div>

          <div class="col-md-6">
            <label for="fechaEncuentro" class="form-label fw-bold">Fecha del encuentro</label>
            <input type="date" class="form-control" id="fechaEncuentro" name="fechaEncuentro" required>
          </div>

          <!-- Datos de contacto si es Invitado -->
          <?php if ($_SESSION['rol'] === 'Invitado'): ?>
            <hr class="mt-4">
            <h5 class="text-danger">Información de contacto (obligatoria para invitados)</h5>

            <div class="col-md-6">
              <label for="contactoNombre" class="form-label fw-bold">Nombre</label>
              <input type="text" class="form-control" id="contactoNombre" name="contactoNombre" required>
            </div>

            <div class="col-md-6">
              <label for="contactoTelefono" class="form-label fw-bold">Teléfono</label>
              <input type="text" class="form-control" id="contactoTelefono" name="contactoTelefono" required>
            </div>

            <div class="col-md-6">
              <label for="contactoEmail" class="form-label fw-bold">Email</label>
              <input type="email" class="form-control" id="contactoEmail" name="contactoEmail" required>
            </div>
          <?php else: ?>
            <!-- Usuario registrado: se asocia automáticamente -->
            <input type="hidden" name="idUsuario" value="<?php echo (int)($_SESSION['idUsuario'] ?? 0); ?>">
          <?php endif; ?>

          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm">
              <i class="bi bi-check-circle me-2"></i> Reportar Encuentro
            </button>
          </div>
          <input type="hidden" name="idMascota" value="<?php echo (int)($_GET['idMascota'] ?? 0); ?>">
        </form>
      </div>
    </div>
  </div>

  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</section>
<?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>
</html>
