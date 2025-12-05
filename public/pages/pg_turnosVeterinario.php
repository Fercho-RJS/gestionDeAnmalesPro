<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

session_start();
$_SESSION['pgActual'] = "turnosVeterinario";

// Validar sesión
if (!isset($_SESSION['user'])) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php");
  exit("Acceso denegado.");
}

// Obtener lista de veterinarios desde la tabla usuario
$sql = "SELECT u.idUsuario, p.nombre, p.apellido, p.email 
        FROM usuario u
        INNER JOIN persona p ON p.idPersona = u.Persona_idPersona
        WHERE u.rol = 'Veterinario' AND u.habilitado = 1
        ORDER BY p.apellido ASC, p.nombre ASC";
$result = $conexion->query($sql);
$veterinarios = [];
while ($row = $result->fetch_assoc()) {
  $veterinarios[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sacar turno - Veterinario</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section id="ContenedorGeneral">
  <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

  <div class="container my-5">
    <h1 class="mb-4 fw-bold text-center">Solicitar turno con un veterinario</h1>
    <hr>

    <?php if (count($veterinarios) > 0): ?>
      <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>turnos/registrar_turno.php" method="post" class="row g-3 needs-validation" novalidate>
        
        <div class="col-md-6">
          <label for="veterinario" class="form-label fw-bold">Seleccionar veterinario</label>
          <select id="veterinario" name="idVeterinario" class="form-select" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($veterinarios as $vet): ?>
              <option value="<?php echo $vet['idUsuario']; ?>">
                <?php echo htmlspecialchars($vet['apellido'] . ", " . $vet['nombre']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="fecha" class="form-label fw-bold">Fecha del turno</label>
          <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label for="hora" class="form-label fw-bold">Hora del turno</label>
          <input type="time" id="hora" name="hora" class="form-control" required>
        </div>

        <div class="col-12">
          <label for="motivo" class="form-label fw-bold">Motivo de la consulta</label>
          <textarea id="motivo" name="motivo" class="form-control" rows="3" required></textarea>
        </div>

        <div class="col-12 text-center mt-4">
          <button type="submit" class="btn btn-success rounded-pill px-5 disabled">
            <i class="bi bi-calendar-check me-2"></i> Reservar turno
          </button>
        </div>
      </form>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        No hay veterinarios habilitados en el sistema actualmente.
      </div>
    <?php endif; ?>
  </div>

  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</section>
<?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>
</html>
