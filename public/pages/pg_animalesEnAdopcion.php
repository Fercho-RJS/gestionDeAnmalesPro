<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "mascotasAdopcion";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Mascotas en Adopción</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
</head>
<body>
  <section id="ContenedorGeneral">
    <?php
    require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
    require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
    ?>

    <section class="m-5">
      <div class="row">
        <div class="col-xl-6 col-lg-auto">
          <h1><b>Base de datos</b> — Mascotas en adopción</h1>
        </div>
      </div>
      <hr>

      <?php
      require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

      // Opcional: activar errores de mysqli durante la depuración
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $porPagina = 6;
      $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
      $inicio = (int)(($pagina - 1) * $porPagina);
      $porPagina = (int)$porPagina;

      // Conteo de registros
      $sqlCount = "SELECT COUNT(*) AS total
                   FROM mascota m
                   INNER JOIN adopciones a ON m.idMascota = a.Mascota_idMascota
                   WHERE a.estado = 'En proceso'";
      $resCount = $conexion->query($sqlCount);
      $totalRegistros = $resCount ? (int)$resCount->fetch_assoc()['total'] : 0;
      $totalPaginas = $totalRegistros > 0 ? (int)ceil($totalRegistros / $porPagina) : 1;

      // Consulta principal
      $sql = "SELECT
                m.idMascota, m.nombre, m.categoria, m.raza, m.edad, m.color, m.height, m.imagen,
                a.fecha_adopcion, a.estado, a.observacionesl
              FROM mascota m
              INNER JOIN adopciones a ON m.idMascota = a.Mascota_idMascota
              WHERE a.estado = 'En proceso'
              ORDER BY a.fecha_adopcion DESC
              LIMIT $inicio, $porPagina";
      $resultado = $conexion->query($sql);
      ?>

      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
          <?php while ($mascota = $resultado->fetch_assoc()): ?>
            <?php
              $imagen = htmlspecialchars($mascota['imagen'] ?? '', ENT_QUOTES, 'UTF-8');
              $nombre = htmlspecialchars($mascota['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
              $categoria = htmlspecialchars($mascota['categoria'] ?? '', ENT_QUOTES, 'UTF-8');
              $raza = htmlspecialchars($mascota['raza'] ?? '', ENT_QUOTES, 'UTF-8');
              $edad = htmlspecialchars($mascota['edad'] ?? '', ENT_QUOTES, 'UTF-8');
              $color = htmlspecialchars($mascota['color'] ?? '', ENT_QUOTES, 'UTF-8');
              $height = htmlspecialchars($mascota['height'] ?? '', ENT_QUOTES, 'UTF-8');
              $estado = htmlspecialchars($mascota['estado'] ?? '', ENT_QUOTES, 'UTF-8');
              $fecha = !empty($mascota['fecha_adopcion']) ? date('d/m/Y', strtotime($mascota['fecha_adopcion'])) : 'Sin fecha';
              $obs = htmlspecialchars($mascota['observacionesl'] ?? '', ENT_QUOTES, 'UTF-8');
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm rounded-4 small">
                <img class="card-img-top rounded-4" src="<?php echo $imagen; ?>" alt="Imagen de mascota" style="object-fit:cover; height:230px;">
                <div class="card-body">
                  <h5 class="card-title fw-bold"><?php echo $nombre; ?></h5>
                  <p class="card-text"><b>Estado:</b> <?php echo $estado; ?></p>
                  <p class="card-text"><b>Fecha de adopción:</b> <?php echo $fecha; ?></p>
                  <p class="card-text"><b>Observaciones:</b> <?php echo $obs ?: '—'; ?></p>
                  <p class="card-text mb-0"><b>Categoría:</b> <?php echo $categoria; ?> | <b>Raza:</b> <?php echo $raza; ?></p>
                  <p class="card-text mb-0"><b>Edad:</b> <?php echo $edad; ?> Año/s</p>
                  <p class="card-text mb-0"><b>Color:</b> <?php echo $color; ?></p>
                  <p class="card-text mb-0"><b>Altura:</b> <?php echo $height; ?></p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <nav class="mt-4" aria-label="Paginación">
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
              <li class="page-item <?php if ($i == $pagina) echo 'active'; ?>">
                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php else: ?>
        <div class="alert alert-dark">No hay mascotas en proceso de adopción.</div>
      <?php endif; ?>
    </section>

    <?php
    require PUBLIC_PAGES_COMPONENTS . 'footer.php';
    require PUBLIC_PAGES_COMPONENTS . 'support.php';
    require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php';
    ?>
  </section>
  <?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>
</html>
