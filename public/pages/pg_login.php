<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();

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
  <title>Ingresar | Comunidad de Animales</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-login.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body id="ContenedorGeneral">
  <?php require PUBLIC_PAGES_COMPONENTS . 'header.php'; ?>

  <div class="container d-flex justify-content-center align-items-center my-5">
    <div class="card shadow-sm border-0" style="max-width: 420px; width: 100%;">
      <div class="card-body text-center">
        <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>icon.png" height="120" class="mb-3" alt="Logo">

        <h4 class="fw-bold mb-4">Ingresar al Sistema</h4>

        <!-- Mensajes de error -->
        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger d-flex align-items-center justify-content-center py-2">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <span>
              <?php if ($_GET['error'] == 'faltan_datos') echo "Por favor, complete todos los campos.";
              elseif ($_GET['error'] == 'usuario_no_existe') echo "El usuario no existe.";
              elseif ($_GET['error'] == 'usuario_no_habilitado') echo "El usuario no está habilitado.";
              elseif ($_GET['error'] == 'password_incorrecta') echo "La contraseña es incorrecta."; ?>
            </span>
          </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>login-usuario.php" method="POST" id="form-login">
          <!-- Usuario -->
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Correo electrónico">
          </div>

          <!-- Contraseña -->
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>

          <button type="submit" class="btn btn-success w-100 rounded-pill mb-3">
            <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
          </button>
        </form>

        <!-- Links secundarios -->
        <div class="small mt-2">
          <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_register.php" class="text-decoration-none text-muted">¿No tenés cuenta?</a> ·
          <a href="#" class="text-decoration-none text-muted">Olvidé mis datos</a>
        </div>

        <!-- Invitado -->
        <form class="mt-4" action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>log-guest.php" method="post">
          <button type="submit" class="btn btn-outline-secondary w-100 rounded-pill">
            <i class="bi bi-person me-1"></i> Acceder como invitado
          </button>
        </form>
      </div>
    </div>
  </div>

  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>

  <!-- Script toggle password -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bi-eye');
      this.querySelector('i').classList.toggle('bi-eye-slash');
    });
  </script>
</body>

</html>