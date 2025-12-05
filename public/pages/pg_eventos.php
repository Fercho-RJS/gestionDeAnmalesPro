<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "eventos";

// Roles permitidos
$rolesPermitidos = ['Publicista', 'Administrador', 'Ayudante'];
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso no autorizado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Eventos</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<section id="ContenedorGeneral">
  <?php
  require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
  require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
  ?>

  <div class="container my-5">
    <div class="row mb-4">
      <div class="col-xl-6 col-lg-auto">
        <h1><b>Eventos</b> — Panel de gestión</h1>
      </div>
      <div class="col-xl-6 col-lg-auto text-end">
        <!-- Botón que abre el modal -->
        <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalNuevoEvento">
          <i class="bi bi-calendar-plus me-2"></i> Nuevo evento
        </button>
      </div>
    </div>
    <hr>

    <?php
    require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

    $sql = "SELECT e.*, u.idUsuario, p.nombre AS nombre_usuario, p.apellido AS apellido_usuario
            FROM eventos e
            LEFT JOIN usuario u ON e.Usuario_idUsuario = u.idUsuario
            LEFT JOIN persona p ON u.Persona_idPersona = p.idPersona
            ORDER BY e.fecha_inicio DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $eventos = [];
    while ($fila = $resultado->fetch_assoc()) {
      $eventos[] = $fila;
    }
    ?>

    <?php if (count($eventos) > 0): ?>
      <div class="row g-4">
        <?php foreach ($eventos as $evento): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm rounded-4 h-100">
              <?php if (!empty($evento['imagen_portada'])): ?>
                <img src="<?php echo htmlspecialchars($evento['imagen_portada']); ?>"
                     alt="Imagen del evento"
                     class="card-img-top rounded-top-4"
                     style="height: 200px; object-fit: cover;">
              <?php endif; ?>

              <div class="card-body">
                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
                <p class="card-text small">
                  <b>Inicio:</b> <?php echo htmlspecialchars($evento['fecha_inicio']); ?><br>
                  <b>Fin:</b> <?php echo htmlspecialchars($evento['fecha_fin']); ?><br>
                  <?php if (!empty($evento['hora_inicio'])): ?>
                    <b>Hora:</b> <?php echo htmlspecialchars($evento['hora_inicio']); ?><br>
                  <?php endif; ?>
                  <b>Estado:</b>
                  <span class="badge 
                    <?php
                      switch ($evento['estado']) {
                        case 'Pendiente': echo 'bg-secondary'; break;
                        case 'En proceso': echo 'bg-warning text-dark'; break;
                        case 'Finalizado': echo 'bg-success'; break;
                      }
                    ?>">
                    <?php echo htmlspecialchars($evento['estado']); ?>
                  </span>
                </p>
                <p class="card-text small text-muted">
                  <b>Organizador:</b> <?php echo htmlspecialchars($evento['nombre_usuario'] . " " . $evento['apellido_usuario']); ?>
                </p>
                <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/eventos/form_editar_evento.php?id=<?php echo $evento['idEventos']; ?>"
                   class="btn btn-outline-primary btn-sm rounded-pill px-3">
                  <i class="bi bi-pencil-square me-1"></i> Editar
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-dark" role="alert">
        No hay eventos registrados.
      </div>
    <?php endif; ?>
  </div>

  <!-- Modal Nuevo Evento -->
  <div class="modal fade" id="modalNuevoEvento" tabindex="-1" aria-labelledby="modalNuevoEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalNuevoEventoLabel"><i class="bi bi-calendar-plus me-2"></i> Registrar nuevo evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="formEvento" method="post" enctype="multipart/form-data"
                action="<?php echo PUBLIC_PAGES_URL; ?>workspace/eventos/nuevoEvento.php"
                class="row g-3 needs-validation" novalidate>

            <div class="col-md-6">
              <label for="titulo" class="form-label fw-bold">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="50">
            </div>

            <div class="col-md-3">
              <label for="fecha_inicio" class="form-label fw-bold">Fecha inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>

            <div class="col-md-3">
              <label for="fecha_fin" class="form-label fw-bold">Fecha fin</label>
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>

            <div class="col-md-3">
              <label for="hora_inicio" class="form-label fw-bold">Hora inicio</label>
              <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
            </div>

            <div class="col-md-3">
              <label for="estado" class="form-label fw-bold">Estado</label>
              <select class="form-select" id="estado" name="estado" required>
                <option value="">Seleccionar</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En proceso">En proceso</option>
                <option value="Finalizado">Finalizado</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="imagen_portada" class="form-label fw-bold">Imagen portada</label>
              <input type="file" class="form-control" id="imagen_portada" name="imagen_portada" accept="image/*">
            </div>

            <div class="col-12">
              <label for="descripcion" class="form-label fw-bold">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-primary rounded-pill px-5">
                <i class="bi bi-check-circle me-2"></i> Registrar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</section>
<?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Validación y alerta al enviar
  document.getElementById('formEvento').addEventListener('submit', function(e) {
    e.preventDefault();

    // Si el formulario no es válido, mostrar validación de Bootstrap
    if (!this.checkValidity()) {
      this.classList.add('was-validated');
      return;
    }

    // Mostrar alerta de confirmación
    Swal.fire({
      title: '¿Confirmar registro?',
      text: 'Se creará un nuevo evento en el sistema.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Enviar el formulario si el usuario confirma
        this.submit();
      }
    });
  });
</script>
