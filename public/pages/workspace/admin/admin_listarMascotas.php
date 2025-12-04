<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

session_start();

// Solo administradores pueden acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso denegado.");
}

$_SESSION['pgActual'] = "admin_listarMascotas";

/*
  Join correcto según tu esquema:
  - mascota.Usuario_idUsuario -> usuario.idUsuario
  - usuario.Persona_idPersona -> persona.idPersona
*/
$sql = "SELECT 
          m.idMascota,
          m.nombre AS nombreMascota,
          m.categoria,
          m.raza,
          m.status,
          m.chipNro,
          u.idUsuario AS propietarioId,
          p.nombre AS propietarioNombre,
          p.apellido AS propietarioApellido,
          p.email AS propietarioEmail
        FROM mascota m
        LEFT JOIN usuario u ON u.idUsuario = m.Usuario_idUsuario
        LEFT JOIN persona p ON p.idPersona = u.Persona_idPersona
        ORDER BY m.nombre ASC";

$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Listado de Mascotas</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>
<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm_navbar.php'; ?>

    <div class="container my-4">
      <h1 class="mb-4">Listado de mascotas</h1>

      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Raza</th>
            <th>Chip</th>
            <th>Propietario</th>
            <th>Email propietario</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): 
            $estado = trim((string)$row['status']);
            // Badge según status (ajusta a tus valores reales)
            if (strcasecmp($estado, 'Perdido') === 0) {
              $badge = '<span class="badge bg-danger">Perdido</span>';
            } elseif (strcasecmp($estado, 'Adoptado') === 0) {
              $badge = '<span class="badge bg-success">Adoptado</span>';
            } elseif (strcasecmp($estado, 'Activo') === 0) {
              $badge = '<span class="badge bg-primary">Activo</span>';
            } else {
              $badge = '<span class="badge bg-secondary">'.htmlspecialchars($estado ?: 'Sin estado').'</span>';
            }

            $propietarioNombre = ($row['propietarioNombre'] || $row['propietarioApellido'])
              ? htmlspecialchars($row['propietarioNombre'].' '.$row['propietarioApellido'])
              : 'Sin asignar';
            $propietarioEmail = $row['propietarioEmail'] ? htmlspecialchars($row['propietarioEmail']) : '—';
          ?>
            <tr>
              <td><?php echo $row['idMascota']; ?></td>
              <td><?php echo htmlspecialchars($row['nombreMascota']); ?></td>
              <td><?php echo htmlspecialchars($row['categoria']); ?></td>
              <td><?php echo htmlspecialchars($row['raza'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($row['chipNro']); ?></td>
              <td><?php echo $propietarioNombre; ?></td>
              <td><?php echo $propietarioEmail; ?></td>
              <td><?php echo $badge; ?></td>
              <td>
                <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/editarMascota.php?id=<?php echo $row['idMascota']; ?>" 
                   class="btn btn-sm btn-primary">Editar</a>

                <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/mascota/dropMascota.php" 
                      method="post" class="d-inline"
                      onsubmit="return confirm('¿Seguro que desea eliminar esta mascota?');">
                  <input type="hidden" name="idMascota" value="<?php echo $row['idMascota']; ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
</body>
</html>
