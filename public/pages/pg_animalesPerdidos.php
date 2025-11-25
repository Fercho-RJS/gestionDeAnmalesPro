<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['pgActual'] = "animalesPerdidos";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Animales Perdidos</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
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
          <h1><b>Base de datos</b> — Mascotas extraviadas</h1>
        </div>
        <div class="col-xl-6 col-lg-auto text-end">
          <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportar_extravio.php" class="btn btn-sm rounded-pill btn-danger px-3">Reportar</a>
        </div>
      </div>
      <hr>

      <?php
      require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php'; // define $conexion (mysqli)

      // Parámetros de paginación
      $porPagina = 6;
      $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
      $inicio = ($pagina - 1) * $porPagina;

      // Contar total de registros
      $sqlCount = "SELECT COUNT(*) as total 
                 FROM mascota m 
                 INNER JOIN perdidos p ON m.idMascota = p.Mascota_idMascota 
                 WHERE p.status = 'Perdido'";
      $resCount = $conexion->query($sqlCount);
      $totalRegistros = $resCount ? (int)$resCount->fetch_assoc()['total'] : 0;
      $totalPaginas = $totalRegistros > 0 ? ceil($totalRegistros / $porPagina) : 1;

      // Validar enteros para LIMIT
      $inicio = (int)$inicio;
      $porPagina = (int)$porPagina;

      // Consulta paginada
      $sql = "SELECT 
              m.idMascota, m.nombre, m.categoria, m.raza, m.edad, m.color, m.height, m.imagen,
              p.descripcion, p.lugar, p.fecha_de_reporte, p.status AS status_perdido
            FROM mascota m
            INNER JOIN perdidos p ON m.idMascota = p.Mascota_idMascota
            WHERE p.status = 'Perdido'
            ORDER BY p.fecha_de_reporte DESC
            LIMIT $inicio, $porPagina";

      $resultado = $conexion->query($sql);
      ?>

      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
          <?php while ($mascota = $resultado->fetch_assoc()): ?>
            <?php
            $imagenBD = $mascota['imagen'] ?? '';
$nombreArchivo = basename($imagenBD); // extrae solo el nombre
$imagen = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL . htmlspecialchars($nombreArchivo, ENT_QUOTES, 'UTF-8');



            $nombre      = htmlspecialchars($mascota['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($mascota['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
            $categoria   = htmlspecialchars($mascota['categoria'] ?? '', ENT_QUOTES, 'UTF-8');
            $raza        = htmlspecialchars($mascota['raza'] ?? '', ENT_QUOTES, 'UTF-8');
            $fecha       = !empty($mascota['fecha_de_reporte']) ? date('d/m/Y', strtotime($mascota['fecha_de_reporte'])) : 'Sin fecha';
            $edad        = htmlspecialchars($mascota['edad'] ?? '', ENT_QUOTES, 'UTF-8');
            $color       = htmlspecialchars($mascota['color'] ?? '', ENT_QUOTES, 'UTF-8');
            $height      = htmlspecialchars($mascota['height'] ?? '', ENT_QUOTES, 'UTF-8');
            $status      = htmlspecialchars($mascota['status_perdido'] ?? '', ENT_QUOTES, 'UTF-8');
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm rounded-4 small">
                <div class="col-12 col-sm-auto text-center mb-3 mb-sm-0">
                  <img class="img-fluid rounded-4"
                    style="height: 220px; object-fit: cover; width: 220px; max-width: 100%;"
                    src="<?php echo $imagen; ?>"
                    alt="Imagen de mascota">
                </div>

                <div class="card-body">
                  <h5 class="card-title fw-bold"><?php echo $nombre; ?></h5>
                  <p class="card-text"><b>Descripciones:</b> <?php echo $descripcion; ?></p>
                  <p class="card-text mb-0"><b>Categoría:</b> <?php echo $categoria; ?> | <b>Raza:</b> <?php echo $raza; ?></p>
                  <p class="card-text mb-0"><b>Fecha de reporte:</b> <?php echo $fecha; ?></p>
                  <p class="card-text mb-0"><b>Edad:</b> <?php echo $edad; ?> Año/s</p>
                  <p class="card-text mb-0"><b>Color/es de Identidad:</b> <?php echo $color; ?></p>
                  <p class="card-text mb-0"><b>Altura / Tamaño:</b> <?php echo $height; ?></p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                  <span class="btn btn-sm 
                  <?php
                  if ($status === 'Encontrado') echo 'btn-success';
                  elseif ($status === 'Perdido') echo 'btn-danger';
                  else echo 'btn-secondary'; ?>">
                    <?php echo $status; ?>
                  </span>
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_reportar_extravio.php?id=<?php echo (int)$mascota['idMascota']; ?>" class="btn btn-sm btn-outline-dark">S.O.S</a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <!-- Paginación -->
        <nav aria-label="Paginación de mascotas perdidas" class="mt-4">
          <ul class="pagination justify-content-center">
            <?php if ($pagina > 1): ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Anterior</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
              <li class="page-item <?php if ($i == $pagina) echo 'active'; ?>">
                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Siguiente</span></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php else: ?>
        <div class="alert alert-dark" role="alert">
          No hay mascotas registradas como perdidas.
        </div>
      <?php endif; ?>
    </section>

    <?php
    require PUBLIC_PAGES_COMPONENTS . 'footer.php';
    require PUBLIC_PAGES_COMPONENTS . 'support.php';
    ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  </section>
</body>

</html>
