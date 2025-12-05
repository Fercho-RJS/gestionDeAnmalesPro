<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['pgActual'] = "registro";

if (isset($_SESSION['idPersona'])) {
  header('location:' . PUBLIC_PAGES_URL . 'pg_main_workspace.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-login.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'header.php'; ?>

    <div id="form-registro" class="container my-3">
      <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>registrar-persona.php" method="post" id="form-registro-contenido" class="bg-white shadow-sm p-3">
        <h2 class="text-center mb-4">Registro de Usuario</h2>
        <p class="text-center">Los campos marcados con <b class="text-danger">(*)</b> deben estar rellenos con la información solicitada.</p>
        <?php if (isset($_GET['m'])): ?>
          <?php if ($_GET['m'] == '409'): ?>
            <div class="alert alert-warning text-center">El DNI o el correo electrónico ya están registrados.</div>
          <?php elseif ($_GET['m'] == '402'): ?>
            <div class="alert alert-danger text-center">Faltan datos obligatorios.</div>
          <?php elseif ($_GET['m'] == '403'): ?>
            <div class="alert alert-danger text-center">Las contraseñas no coinciden.</div>
          <?php elseif ($_GET['m'] == '201'): ?>
            <div class="alert alert-success text-center">¡Registro exitoso! En las próximas 72hs se confirmará tu cuenta.</div>
          <?php endif; ?>
        <?php endif; ?>

        <!-- Datos personales -->
        <h5 class="mt-4">Datos personales</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre/s <span class="text-danger">*</span></label>
            <input type="text" name="nombre" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Apellido/s <span class="text-danger">*</span></label>
            <input type="text" name="apellido" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="documento">Documento N° <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
              <input type="text" name="documento" id="documento" class="form-control" required
                inputmode="numeric" pattern="[0-9]+" maxlength="12"
                title="Ingrese solo números. Este campo es obligatorio.">
              <button type="button" class="btn btn-outline-secondary"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Este dato se utiliza para medidas de seguridad y prevención de abandono de animales.">
                <i class="bi bi-info-circle"></i>
              </button>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tipo de documento <span class="text-danger">*</span></label>
            <select name="tipoDocumento" class="form-select form-select-sm" required>
              <option value="" disabled selected>Seleccione</option>
              <option value="1">DNI</option>
              <option value="2">Pasaporte</option>
              <option value="3">Otro</option>
            </select>
          </div>
        </div>

        <!-- Contacto -->
        <h5 class="mt-4">Contacto</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control form-control-sm" required>
          </div>
        </div>

        <!-- Domicilio -->
        <h5 class="mt-4">Domicilio</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Calle <span class="text-danger">*</span></label>
            <input type="text" name="domicilio" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Altura <span class="text-danger">*</span></label>
            <input type="text" name="domicilioAltura" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Piso</label>
            <input type="text" name="piso" class="form-control form-control-sm">
          </div>
          <div class="col-md-3">
            <label class="form-label">Depto</label>
            <input type="text" name="depto" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label class="form-label">Barrio <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm" name="barrio" required>
              <option selected disabled>Seleccione su barrio</option>
              <option value="Belgrano">Belgrano</option>
              <option value="Juan Caparroz">Juan Caparroz</option>
              <option value="Juan XXIII">Juan XXIII</option>
              <option value="Jose Dho">José Dho</option>
              <option value="Mariano Moreno">Mariano Moreno</option>
              <option value="Palermo">Palermo</option>
              <option value="Pellegrini">Pellegrini</option>
              <option value="Rivadavia">Rivadavia</option>
              <option value="San Martín">San Martín</option>
              <option value="Sargento Bustamante">Sargento Bustamante</option>
              <option value="Tiro Federal">Tiro Federal</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Localidad <span class="text-danger">*</span></label>
            <input type="text" name="localidad" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Provincia <span class="text-danger">*</span></label>
            <input type="text" name="provincia" class="form-control form-control-sm" required>
          </div>
        </div>

        <!-- Acceso -->
        <h5 class="mt-4">Datos de acceso</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Contraseña <span class="text-danger">*</span></label>
            <input type="password" name="contrasena" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
            <input type="password" name="validarContrasena" class="form-control form-control-sm" required>
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-success rounded-pill px-4">Registrarme</button>
          <button type="reset" class="btn btn-secondary rounded-pill px-4 ms-2">Reiniciar</button>
        </div>
      </form>
    </div>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
      });
    </script>
  </section>
</body>

</html>