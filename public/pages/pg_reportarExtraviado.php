<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['pgActual'] = "reportarExtraviado";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportar Mascota Extraviada</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php
    require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
    require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
    ?>

    <div class="container my-4">
      <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/registrar-extraviado.php"
        method="post" enctype="multipart/form-data"
        class="bg-white shadow-sm p-4 rounded-3">

        <h2 class="text-center mb-4">Reportar Mascota Extraviada</h2>

        <!-- Datos básicos -->
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre de la mascota <span class="text-danger">*</span></label>
            <input type="text" name="nombre" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Categoría <span class="text-danger">*</span></label>
            <select name="categoria" class="form-select form-select-sm" required>
              <option disabled selected>Seleccione</option>
              <option value="Perro">Perro</option>
              <option value="Gato">Gato</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Raza</label>
            <input type="text" name="raza" class="form-control form-control-sm">
          </div>
          <div class="col-md-3">
            <label class="form-label">Edad (años)</label>
            <input type="number" name="edad" class="form-control form-control-sm" min="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Color/es <span class="text-danger">*</span></label>
            <input type="text" name="color" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Altura/Tamaño</label>
            <input type="text" name="height" class="form-control form-control-sm">
          </div>
        </div>

        <!-- Descripción -->
        <div class="mt-3">
          <label class="form-label">Descripción del extravío <span class="text-danger">*</span></label>
          <textarea name="descripcion" class="form-control form-control-sm" rows="3" required></textarea>
        </div>

        <!-- Lugar y fecha -->
        <div class="row g-3 mt-3">
          <div class="col-md-6">
            <label class="form-label">Lugar del extravío <span class="text-danger">*</span></label>
            <input type="text" name="lugar" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Fecha del reporte <span class="text-danger">*</span></label>
            <input type="date" name="fecha_de_reporte" class="form-control form-control-sm" required>
          </div>
        </div>

        <!-- Imagen -->
        <div class="mt-3">
          <label class="form-label">Imagen de la mascota <span class="text-danger">*</span></label>
          <input type="file" name="imagen" class="form-control form-control-sm"
            accept=".jpg,.jpeg,.png,.webp" required>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-danger rounded-pill px-4">Reportar</button>
          <button type="reset" class="btn btn-secondary rounded-pill px-4 ms-2">Reiniciar</button>
        </div>
      </form>
    </div>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  </section>
</body>

</html>