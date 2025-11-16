<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "asignarVacunacion";

if (!isset($_SESSION['idPersona']) || $_SESSION['rol'] === 'Invitado') {
  header('location:' . PUBLIC_PAGES_URL . 'pg_login.php');
  exit();
}

require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
$idUsuario = $_SESSION['idPersona'];

// Obtener mascotas del usuario
$sqlMascotas = "SELECT idMascota, nombre FROM mascota WHERE Usuario_idUsuario = ?";
$stmtMascotas = $conexion->prepare($sqlMascotas);
$stmtMascotas->bind_param("i", $idUsuario);
$stmtMascotas->execute();
$mascotas = $stmtMascotas->get_result();

// Obtener vacunas disponibles
$sqlVacunas = "SELECT idVacunas, nombre FROM vacunas ORDER BY nombre ASC";
$vacunas = $conexion->query($sqlVacunas);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Asignar Vacunación</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

    <div class="container my-5">
      <h2 class="fw-bold mb-4">Asignar Vacunación</h2>

      <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/veterinario/forms/action_guardarVacunacion.php" method="POST" class="row g-3">
        <div class="col-md-6">
          <label for="mascota" class="form-label">Mascota</label>
          <select name="Mascota_idMascota" id="mascota" class="form-select select2" required>
            <option value="">Seleccionar mascota</option>
            <?php while ($m = $mascotas->fetch_assoc()): ?>
              <option value="<?php echo $m['idMascota']; ?>"><?php echo htmlspecialchars($m['nombre']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="vacuna" class="form-label">Vacuna</label>
          <select name="Vacunas_idVacunas" id="vacuna" class="form-select select2" required>
            <option value="">Seleccionar vacuna</option>
            <?php while ($v = $vacunas->fetch_assoc()): ?>
              <option value="<?php echo $v['idVacunas']; ?>"><?php echo htmlspecialchars($v['nombre']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="veterinario" class="form-label">Veterinario</label>
          <input type="text" name="veterinario" id="veterinario" class="form-control" maxlength="60" required>
        </div>

        <div class="col-md-6">
          <label for="numero_serie" class="form-label">Número de serie</label>
          <input type="text" name="numero_serie" id="numero_serie" class="form-control" maxlength="60" required>
        </div>

        <div class="col-md-4">
          <label for="fecha_elaboracion" class="form-label">Fecha de elaboración</label>
          <input type="date" name="fecha_elaboracion" id="fecha_elaboracion" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label for="fecha_caducidad" class="form-label">Fecha de caducidad</label>
          <input type="date" name="fecha_caducidad" id="fecha_caducidad" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label for="proxima_dosis" class="form-label">Próxima dosis</label>
          <input type="date" name="proxima_dosis" id="proxima_dosis" class="form-control">
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">Guardar vacunación</button>
        </div>
      </form>
    </div>

    <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.select2').select2({
          width: '100%',
          placeholder: 'Seleccionar',
          allowClear: true,
          maximumResults: 25
        });
      });
    </script>
  </section>
</body>

</html>