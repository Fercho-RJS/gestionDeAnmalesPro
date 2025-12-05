<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "dashboard";

// Validar acceso de administrador
if (!isset($_SESSION['user']) || $_SESSION['rol'] !== 'Administrador') {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm_navbar.php'; ?>

    <section class="container my-5">
      <h1 class="fw-bold mb-4 text-center">Panel de Administración</h1>
      <hr>

      <!-- Paneles resumen -->
      <div class="row g-4 mb-5">
        <!-- Usuarios registrados -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-4 bg-light h-100">
            <div class="d-flex justify-content-center align-items-center mb-2">
              <i class="bi bi-people-fill text-primary fs-1 me-2"></i>
              <h5 class="fw-bold mb-0">Usuarios registrados</h5>
            </div>

            <?php
            require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

            // Contar usuarios registrados
            $sqlUsuarios = "SELECT COUNT(*) AS total FROM usuario";
            $resUsuarios = $conexion->query($sqlUsuarios);
            $totalUsuarios = 0;

            if ($resUsuarios && $resUsuarios->num_rows > 0) {
              $totalUsuarios = (int)$resUsuarios->fetch_assoc()['total'];
            }
            ?>

            <p class="display-5 fw-bold text-primary mb-3"><?php echo $totalUsuarios; ?></p>

            <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarUsuarios.php"
              class="btn btn-primary btn-sm rounded-pill px-3">
              <i class="bi bi-eye"></i> Ver usuarios
            </a>
          </div>
        </div>

        <!-- Mascotas activas -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-4 bg-light h-100">
            <div class="d-flex justify-content-center align-items-center mb-2">
              <i class="bi bi-house-heart-fill text-success fs-1 me-2"></i>
              <h5 class="fw-bold mb-0">Mascotas Adoptadas</h5>
            </div>


            <?php
            require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

            // Contar mascotas activas (ejemplo: status = 'Activo')
            $sqlMascotas = "SELECT COUNT(*) AS total FROM mascota WHERE status = 'Adoptado'";
            $resMascotas = $conexion->query($sqlMascotas);
            $totalMascotas = 0;

            if ($resMascotas && $resMascotas->num_rows > 0) {
              $totalMascotas = (int)$resMascotas->fetch_assoc()['total'];
            }
            ?>

            <p class="display-5 fw-bold text-success mb-3"><?php echo $totalMascotas; ?></p>

            <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarMascotas.php"
              class="btn btn-success btn-sm rounded-pill px-3">
              <i class="bi bi-eye"></i> Ver mascotas
            </a>
          </div>
        </div>


        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-4 bg-light h-100">
            <div class="d-flex justify-content-center align-items-center mb-2">
              <i class="bi bi-exclamation-triangle-fill text-danger fs-1 me-2"></i>
              <h5 class="fw-bold mb-0">Reportes de extravío</h5>
            </div>

            <?php
            require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

            // Contar reportes de extravío (ejemplo: status = 'Perdido')
            $sqlReportes = "SELECT COUNT(*) AS total FROM perdidos WHERE status = 'Perdido'";
            $resReportes = $conexion->query($sqlReportes);
            $totalReportes = 0;

            if ($resReportes && $resReportes->num_rows > 0) {
              $totalReportes = (int)$resReportes->fetch_assoc()['total'];
            }
            ?>

            <p class="display-5 fw-bold text-danger mb-3"><?php echo $totalReportes; ?></p>

            <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_animalesPerdidos.php"
              class="btn btn-danger btn-sm rounded-pill px-3">
              <i class="bi bi-eye"></i> Ver reportes
            </a>
          </div>
        </div>


        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0 rounded-4 text-center p-4 bg-light h-100">
            <div class="d-flex justify-content-center align-items-center mb-2">
              <i class="bi bi-hourglass-split text-warning fs-1 me-2"></i>
              <h5 class="fw-bold mb-0">Solicitudes pendientes</h5>
            </div>

            <?php
            require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

            // Contar usuarios pendientes de habilitación
            $sqlPendientes = "SELECT COUNT(*) AS total 
                      FROM usuario 
                      WHERE habilitado = '0'";
            // Ajusta según el campo real de tu tabla
            $resPendientes = $conexion->query($sqlPendientes);
            $totalPendientes = 0;

            if ($resPendientes && $resPendientes->num_rows > 0) {
              $totalPendientes = (int)$resPendientes->fetch_assoc()['total'];
            }
            ?>

            <p class="display-5 fw-bold text-warning mb-3"><?php echo $totalPendientes; ?></p>

            <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/admin_listarUsuarios.php"
              class="btn btn-warning btn-sm rounded-pill px-3">
              <i class="bi bi-eye"></i> Revisar
            </a>
          </div>
        </div>

      </div>

      <!-- Sección de actividad reciente -->
      <div class="card shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-3">Actividad reciente</h4>
        <ul class="list-group list-group-flush">
          <?php
          require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

          // Página actual (por defecto 1)
          $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
          if ($pagina < 1) $pagina = 1;

          $registros_por_pagina = 10;
          $offset = ($pagina - 1) * $registros_por_pagina;

          // Consulta con paginación
          $sql = "SELECT usuario_id, rol, accion, fecha 
            FROM log_acciones 
            ORDER BY fecha DESC 
            LIMIT $registros_por_pagina OFFSET $offset";

          $result = $conexion->query($sql);

          if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
              $usuario_id = $row['usuario_id'];
              $rol        = htmlspecialchars($row['rol'] ?? 'Sistema', ENT_QUOTES, 'UTF-8');
              $accion     = htmlspecialchars($row['accion'] ?? '', ENT_QUOTES, 'UTF-8');
              $fecha      = date('d/m/Y H:i', strtotime($row['fecha']));

              // Opcional: obtener nombre de usuario
              $nombre_usuario = 'Usuario #' . $usuario_id;
              if ($usuario_id) {
                $qUser = $conexion->query("SELECT nombre FROM usuario WHERE idUsuario = $usuario_id LIMIT 1");
                if ($qUser && $qUser->num_rows > 0) {
                  $nombre_usuario = htmlspecialchars($qUser->fetch_assoc()['nombre'], ENT_QUOTES, 'UTF-8');
                }
              }
          ?>
              <li class="list-group-item">
                📌 <b><?php echo $nombre_usuario; ?></b> (<?php echo $rol; ?>) — <?php echo $accion; ?>
                <br><small class="text-muted"><?php echo $fecha; ?></small>
              </li>
            <?php endwhile;
          else: ?>
            <li class="list-group-item text-muted">No hay actividad registrada recientemente.</li>
          <?php endif; ?>
        </ul>

        <?php
        // Calcular total de registros para la paginación
        $sqlTotal = "SELECT COUNT(*) AS total FROM log_acciones";
        $totalResult = $conexion->query($sqlTotal);
        $totalRegistros = ($totalResult && $totalResult->num_rows > 0) ? (int)$totalResult->fetch_assoc()['total'] : 0;
        $totalPaginas = ceil($totalRegistros / $registros_por_pagina);
        ?>

        <!-- Navegación de paginación -->
        <nav aria-label="Actividad reciente" class="mt-3">
          <ul class="pagination justify-content-center">
            <?php if ($pagina > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
              <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>


    </section>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm-phone-navbar.php'; ?>
  </section>
</body>

</html>