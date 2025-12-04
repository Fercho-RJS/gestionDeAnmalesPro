<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';

// Solo usuarios logueados que no sean Invitado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] === 'Invitado') {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso denegado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registrar Mascota</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

    <div class="container my-5">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h1 class="mb-4 text-center text-success">
            <i class="bi bi-heart-fill me-2"></i>Registrar nueva mascota
          </h1>

          <!-- Abrimos el form y abarcamos ambas columnas -->
          <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/registrar-nueva-mascota.php"
            method="post" enctype="multipart/form-data">

            <div class="row">
              <!-- Columna izquierda: imagen -->
              <div class="col-md-4 text-center border-end">
                <img id="preview" src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>animal.png"
                  alt="Previsualización" class="img-fluid rounded mb-3 shadow-sm" style="max-height:280px;">
                <div class="mb-3">
                  <label for="imagenUrl" class="form-label fw-bold">Foto de la mascota</label>
                  <input type="file" class="form-control" id="imagenUrl" name="imagenUrl"
                    accept="image/*" onchange="previewImage(event)">
                </div>
              </div>

              <!-- Columna derecha: campos -->
              <div class="col-md-8">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="nombre" class="form-label fw-bold">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Firulais" required>
                  </div>

                  <div class="col-md-6">
                    <label for="tipo" class="form-label fw-bold">Categoría</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                      <option value="">Seleccionar...</option>
                      <option value="Perro">Perro</option>
                      <option value="Gato">Gato</option>
                      <option value="Ave">Ave</option>
                      <option value="Otro">Otro</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="raza" class="form-label fw-bold">Raza</label>
                    <input type="text" class="form-control" id="raza" name="raza" placeholder="Ej: Labrador" required>
                  </div>

                  <div class="col-md-6">
                    <label for="colorList" class="form-label fw-bold">Color</label>
                    <input type="text" class="form-control" id="colorList" name="colorList" placeholder="Ej: Marrón" required>
                  </div>

                  <div class="col-md-6">
                    <label for="fechaNacimiento" class="form-label fw-bold">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                  </div>

                  <div class="col-md-6">
                    <label for="tamanio" class="form-label fw-bold">Tamaño</label>
                    <select id="tamanio" name="tamanio" class="form-select" required>
                      <option value="">Seleccionar...</option>
                      <option value="Pequeño">Pequeño</option>
                      <option value="Mediano">Mediano</option>
                      <option value="Grande">Grande</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="fechaAdopcion" class="form-label fw-bold">Fecha de adopción</label>
                    <input type="date" class="form-control" id="fechaAdopcion" name="fechaAdopcion">
                  </div>

                  <div class="col-md-6">
                    <label for="chipNro" class="form-label fw-bold">Código de seguimiento (chipNro)</label>
                    <input type="text" class="form-control" id="chipNro" name="chipNro"
                      placeholder="Opcional: si no lo completas se genera uno automático">
                  </div>

                  <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm">
                      <i class="bi bi-check-circle me-2"></i>Registrar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>

  <script>
    function previewImage(event) {
      const input = event.target;
      const preview = document.getElementById('preview');
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>


  <!-- Footer y scripts -->
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>

</html>