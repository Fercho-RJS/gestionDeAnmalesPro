<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Política de Privacidad</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-about.css">
</head>

<body id="ContenedorGeneral">
  <?php require PUBLIC_PAGES_COMPONENTS . 'header.php'; ?>

  <section class="container my-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="fw-bold text-center mb-4">Política de Privacidad</h1>
        <p class="text-muted text-center">Última actualización: <?php echo date("Y-m-d"); ?></p>

        <h3 class="fw-bold mt-4">1. Información que recopilamos</h3>
        <ul class="text-muted">
          <li>Datos personales como nombre, correo electrónico y contraseña al registrarse.</li>
          <li>Información relacionada con actividades dentro del sistema (donaciones, adopciones, publicaciones).</li>
          <li>Datos técnicos (dirección IP, navegador, fecha y hora de acceso).</li>
        </ul>

        <h3 class="fw-bold mt-4">2. Uso de la información</h3>
        <p class="text-muted">Utilizamos los datos para:</p>
        <ul class="text-muted">
          <li>Identificar usuarios registrados.</li>
          <li>Gestionar actividades del refugio (adopciones, eventos, reportes).</li>
          <li>Mejorar la experiencia del sistema y ofrecer soporte técnico.</li>
        </ul>

        <h3 class="fw-bold mt-4">3. Almacenamiento y seguridad</h3>
        <p class="text-muted">
          Los datos se almacenan en servidores seguros. Implementamos medidas técnicas y organizativas para evitar accesos no autorizados.
          Las contraseñas están cifradas.
        </p>

        <h3 class="fw-bold mt-4">4. Compartición de datos</h3>
        <p class="text-muted">
          No compartimos, vendemos ni alquilamos datos personales a terceros, salvo obligación legal.
        </p>

        <h3 class="fw-bold mt-4">5. Derechos del usuario</h3>
        <p class="text-muted">Podés ejercer tus derechos de:</p>
        <ul class="text-muted">
          <li>Acceder a tus datos personales.</li>
          <li>Rectificar información incorrecta.</li>
          <li>Solicitar la eliminación de tu cuenta.</li>
          <li>Solicitar más información a nuestro equipo técnico.</li>
        </ul>

        <h3 class="fw-bold mt-4">6. Cookies</h3>
        <p class="text-muted">
          Utilizamos cookies funcionales para mejorar el funcionamiento del sistema. No se utilizan con fines publicitarios ni de rastreo.
        </p>

        <h3 class="fw-bold mt-4">7. Contacto</h3>
        <p class="text-muted">
          Por dudas sobre privacidad, escribinos a:
          <a href="mailto:soporte@sgra.com" class="text-decoration-none"><i class="bi bi-envelope"></i> soporte@sgra.com</a>
          o a través del botón de soporte técnico del sitio.
        </p>
      </div>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
</body>

</html>