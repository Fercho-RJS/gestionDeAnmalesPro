<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
if (!session_id()) {
  session_start();
}
$_SESSION['pgActual'] = "vacunas";

if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] === 'Invitado') {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}

require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
$idUsuario = $_SESSION['idUsuario'];

// Consulta mascotas del usuario
$sqlMascotas = "SELECT * FROM mascota WHERE Usuario_idUsuario = ?";
$stmtMascotas = $conexion->prepare($sqlMascotas);
$stmtMascotas->bind_param("i", $idUsuario);
$stmtMascotas->execute();
$resultMascotas = $stmtMascotas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vacunas de mis Mascotas</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
</head>
<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

    <div class="container my-5">
      <h2 class="fw-bold mb-4">Vacunas de mis Mascotas</h2>

      <?php if ($resultMascotas->num_rows === 0): ?>
        <div class="alert alert-warning">No se encontraron mascotas registradas.</div>
      <?php else: ?>
        <div class="row g-4">
          <?php while ($mascota = $resultMascotas->fetch_assoc()): ?>
            <div class="col-md-6">
              <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">
                  <?php echo htmlspecialchars($mascota['nombre']); ?> (<?php echo $mascota['categoria']; ?>)
                </div>
                <div class="card-body">
                  <?php
                  $idMascota = $mascota['idMascota'];
                  $sqlVacunas = "
                    SELECT vm.*, v.nombre AS vacuna_nombre, v.fabricante, v.dosis_requeridas, v.intervalo_dias
                    FROM vacunas_mascota vm
                    JOIN vacunas v ON vm.Vacunas_idVacunas = v.idvacunas
                    WHERE vm.Mascota_idMascota = ?
                    ORDER BY vm.fecha_colocacion DESC
                  ";
                  $stmtVacunas = $conexion->prepare($sqlVacunas);
                  if (!$stmtVacunas) {
                    echo "<p class='text-danger'>Error en la consulta de vacunas: " . $conexion->error . "</p>";
                    continue;
                  }
                  $stmtVacunas->bind_param("i", $idMascota);
                  $stmtVacunas->execute();
                  $resultVacunas = $stmtVacunas->get_result();

                  if ($resultVacunas->num_rows === 0): ?>
                    <p class="text-muted">No hay vacunas registradas para esta mascota.</p>
                  <?php else: ?>
                    <ul class="list-group list-group-flush">
                      <?php while ($vacuna = $resultVacunas->fetch_assoc()): ?>
                        <li class="list-group-item">
                          <strong><?php echo htmlspecialchars($vacuna['vacuna_nombre']); ?></strong><br>
                          <small>
                            Fabricante: <?php echo htmlspecialchars($vacuna['fabricante']); ?><br>
                            Dosis requeridas: <?php echo htmlspecialchars($vacuna['dosis_requeridas']); ?><br>
                            Intervalo entre dosis: <?php echo $vacuna['intervalo_dias'] ? $vacuna['intervalo_dias'] . ' días' : 'No aplica'; ?><br>
                            Aplicada por: <?php echo htmlspecialchars($vacuna['veterinario']); ?><br>
                            Serie: <?php echo htmlspecialchars($vacuna['numero_serie']); ?><br>
                            Fecha de colocación: <?php echo date("d/m/Y", strtotime($vacuna['fecha_colocacion'])); ?><br>
                            Fecha de caducidad: <?php echo date("d/m/Y", strtotime($vacuna['fecha_caducidad'])); ?><br>
                            Próxima dosis: <?php echo $vacuna['proxima_dosis'] ? date("d/m/Y", strtotime($vacuna['proxima_dosis'])) : 'No programada'; ?>
                          </small>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  </section>
</body>
</html>
