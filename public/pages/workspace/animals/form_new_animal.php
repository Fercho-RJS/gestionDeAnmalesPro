<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
// Bloquear acceso a invitados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] === 'Invitado') {
  // Redirigir al login o mostrar mensaje
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=acceso_invitado");
  exit("Acceso denegado para invitados.");
}
?>
$_SESSION['pgActual'] = "misMascotas";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Mascota</title>

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

  <section class="m-5">
    <div class="row">
      <div class="col-6">
        <p>Registrar una mascota para <b><?php echo strtoupper($_SESSION['user']); ?></b></p>
      </div>
      <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/registrar-nueva-mascota.php" method="post" enctype="multipart/form-data">
        <div class="text-end">
          <button type="submit" class="btn btn-success rounded-circle"><i class="bi bi-plus-circle"></i></button>
          <button type="reset" class="btn btn-secondary rounded-circle"><i class="bi bi-arrow-clockwise"></i></button>
        </div>
        <hr>
        <div class="col-12 text-center">
          <?php if (isset($_GET['error']) && $_GET['error'] === 'missing_fields'): ?>
            <div class="alert alert-danger" role="alert">
              Por favor, complete todos los campos obligatorios.
            </div>
          <?php endif; ?>
        </div>

        <div class="row mt-5 mt-xl-4">
          <div class="col-xl-2 col-12 text-center">
            <img id="previewImagen" src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>animal.png" alt="" class="img-fluid rounded-4" style="max-height: 220px;">
          </div>

          <div class="col-xl-5 col-12 mt-3 mt-xl-0">
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Nombre</span>
              <input id="nombre" name="nombre" type="text" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Raza</span>
              <input type="text" id="raza" name="raza" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Fecha de nacimiento</span>
              <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control border-0 border-bottom">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Imagen</span>
              <input type="file" id="imagenUrl" name="imagenUrl" class="form-control border-0 border-bottom" accept="image/*" onchange="mostrarVistaPrevia(event)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Fecha de Adopción</span>
              <input type="date" id="fechaAdopcion" name="fechaAdopcion" class="form-control border-0 border-bottom">
            </div>
          </div>

          <div class="col-xl-5 col-12 mt-2 mt-xl-0">
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Tipo</span>
              <input type="text" id="tipo" name="tipo" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Color/es</span>
              <input type="text" id="colorList" name="colorList" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">Tamaño</span>
              <input type="text" id="tamanio" name="tamanio" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text bg-transparent border-0 border-bottom">CID</span>
              <input type="text" id="codigoAnimal" name="codigoAnimal" class="form-control border-0 border-bottom" placeholder="(Ingresar)">
            </div>
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-success w-100">Agregar Animal</button>
              <button type="reset" class="btn btn-secondary ms-2">Reiniciar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  <?php
  if ($_SESSION['rol'] == 'Usuario' || $_SESSION['rol'] == 'Invitado') {
    require PUBLIC_PAGES_COMPONENTS . 'prohibir_inspeccionar_elemento.php';
  }
  require PUBLIC_PAGES_COMPONENTS . 'footer.php';
  require PUBLIC_PAGES_COMPONENTS . 'support.php';
  ?>
</section>
</body>
</html>
