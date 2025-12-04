<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['pgActual'] = "inicio";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Inicio</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">

  <style>
    .section-title {
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 2rem;
    }

    .card img {
      object-fit: cover;
      height: 180px;
    }

    .badge-custom {
      font-size: 0.9rem;
      padding: 0.4em 0.6em;
    }
  </style>
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'marquee.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

    <section class="m-4 text-center">
      <h1 class="fw-bold mb-3">Portal del Refugio Animal</h1>
      <p class="lead">Bienvenido al portal del refugio animal. Aquí puedes gestionar la información de las mascotas, reportar extravíos y descubrir las últimas novedades.</p>

      <a class="btn btn-lg btn-danger rounded-pill my-3" href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportarExtraviado.php">
        <i class="bi bi-exclamation-triangle"></i> Reportar Extravío
      </a>

      <!-- Últimos eventos -->
      <h2 class="section-title">Últimos eventos</h2>
      <hr>
      <div id="eventosRecientes" class="row mt-4">
        <div class="col-md-4">
          <div class="card shadow-sm">
            <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>evento1.jpg" class="card-img-top" alt="Evento 1">
            <div class="card-body">
              <h5 class="card-title">🐶 Evento de Adopción</h5>
              <p class="card-text">Únete a nosotros para un día de adopción de mascotas.</p>
              <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_adopciones.php" class="btn btn-outline-primary w-100">Más información</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>evento2.jpg" class="card-img-top" alt="Evento 2">
            <div class="card-body">
              <h5 class="card-title">💉 Campaña de Vacunación</h5>
              <p class="card-text">Aprovecha nuestra campaña de vacunación gratuita para mascotas.</p>
              <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_veterinarios.php" class="btn btn-outline-primary w-100">Más información</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <img src="<?php echo PUBLIC_RESOURCES_IMAGES_URL; ?>evento3.jpg" class="card-img-top" alt="Evento 3">
            <div class="card-body">
              <h5 class="card-title">📚 Taller de Cuidado Animal</h5>
              <p class="card-text">Aprende sobre el cuidado adecuado de las mascotas en nuestro taller.</p>
              <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_tienda.php" class="btn btn-outline-primary w-100">Más información</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Animales extraviados -->
      <h2 class="section-title">Animales extraviados</h2>
      <hr>
      <div id="animalesExtraviados" class="row mt-4">
        <?php
        require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
        $sql = "SELECT 
            m.idMascota, m.nombre, m.imagen,
            p.descripcion, p.lugar, p.Mascota_idMascota
          FROM mascota m
          INNER JOIN perdidos p ON m.idMascota = p.Mascota_idMascota
          WHERE p.status = 'Perdido'
          ORDER BY p.fecha_de_reporte DESC
          LIMIT 3";
        $result = $conexion->query($sql);
        ?>

        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $imagen      = htmlspecialchars($row['imagen'] ?? '', ENT_QUOTES, 'UTF-8');
            $nombre      = htmlspecialchars($row['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($row['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
            $lugar       = htmlspecialchars($row['lugar'] ?? '', ENT_QUOTES, 'UTF-8');
            $idMascota   = (int)($row['Mascota_idMascota'] ?? 0);
            ?>
            <div class="col-md-4">
              <div class="card shadow-sm h-100">
                <img src="<?php echo $imagen; ?>" class="card-img-top" alt="<?php echo $nombre; ?>">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $nombre; ?></h5>
                  <span class="badge bg-danger badge-custom mb-2">Extraviado</span>
                  <p class="card-text">
                    <?php echo $descripcion ?: 'Sin descripción'; ?><br>
                    <strong>Zona:</strong> <?php echo $lugar ?: 'No especificada'; ?>
                  </p>
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportar_extravio.php?id=<?php echo $idMascota; ?>" class="btn btn-outline-dark w-100 rounded-pill">
                    <i class="bi bi-search"></i> Más información
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info">No hay animales extraviados reportados recientemente.</div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <?php
    if ($_SESSION['rol'] == 'Usuario' || $_SESSION['rol'] == 'Invitado') {
      require PUBLIC_PAGES_COMPONENTS . 'prohibir_inspeccionar_elemento.php';
    }
    ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  </section>
  
  <?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>

</html>