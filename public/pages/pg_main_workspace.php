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
        <?php
        require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
        $sqlEventos = "SELECT idEventos, titulo, descripcion, fecha_inicio, fecha_fin, hora_inicio, estado, imagen_portada
                       FROM eventos
                       ORDER BY fecha_inicio DESC
                       LIMIT 3";
        $resEventos = $conexion->query($sqlEventos);
        ?>

        <?php if ($resEventos && $resEventos->num_rows > 0): ?>
          <?php while ($ev = $resEventos->fetch_assoc()): ?>
            <?php
            $titulo      = htmlspecialchars($ev['titulo'] ?? '', ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($ev['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
            $fechaInicio = htmlspecialchars($ev['fecha_inicio'] ?? '', ENT_QUOTES, 'UTF-8');
            $fechaFin    = htmlspecialchars($ev['fecha_fin'] ?? '', ENT_QUOTES, 'UTF-8');
            $horaInicio  = htmlspecialchars($ev['hora_inicio'] ?? '', ENT_QUOTES, 'UTF-8');
            $estado      = htmlspecialchars($ev['estado'] ?? '', ENT_QUOTES, 'UTF-8');
            $imagen      = !empty($ev['imagen_portada']) ? htmlspecialchars($ev['imagen_portada'], ENT_QUOTES, 'UTF-8')
              : PUBLIC_RESOURCES_IMAGES_URL . "evento_default.jpg";
            ?>
            <div class="col-md-4">
              <div class="card shadow-sm h-100">
                <img src="<?php echo $imagen; ?>" class="card-img-top" alt="<?php echo $titulo; ?>">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $titulo; ?></h5>
                  <span class="badge bg-secondary badge-custom mb-2"><?php echo $estado; ?></span>
                  <p class="card-text small">
                    <b>Inicio:</b> <?php echo $fechaInicio; ?><br>
                    <b>Fin:</b> <?php echo $fechaFin; ?><br>
                    <?php if (!empty($horaInicio)): ?>
                      <b>Hora:</b> <?php echo $horaInicio; ?><br>
                    <?php endif; ?>
                  </p>
                  <p class="card-text"><?php echo $descripcion ?: 'Sin descripción'; ?></p>
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_eventos.php" class="btn btn-outline-primary w-100 rounded-pill">
                    <i class="bi bi-info-circle"></i> Más información
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info">No hay eventos registrados recientemente.</div>
          </div>
        <?php endif; ?>
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
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php?id=<?php echo $idMascota; ?>" class="btn btn-outline-dark w-100 rounded-pill">
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