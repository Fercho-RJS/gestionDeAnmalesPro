<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';

session_start();

// Solo administradores pueden acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=403");
  exit("Acceso denegado.");
}

$_SESSION['pgActual'] = "admin_listarUsuarios";

// Leer usuarios de la BD
$sql = "SELECT u.idUsuario, u.rol, u.habilitado,
               p.nombre, p.apellido, p.email, p.dni
        FROM usuario u
        INNER JOIN persona p ON p.idPersona = u.Persona_idPersona
        ORDER BY p.apellido ASC, p.nombre ASC";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Listado de Usuarios</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm_navbar.php'; ?>

    <div class="container my-4">
      <h1 class="mb-4">Listado de usuarios</h1>

      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>DNI</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['idUsuario']; ?></td>
              <td><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td><?php echo htmlspecialchars($row['apellido']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['dni']); ?></td>
              <td>
                <!-- Formulario para cambiar rol -->
                <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/admin_updateRol.php" method="post" class="d-flex align-items-center">
                  <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                  <select name="rol" class="form-select form-select-sm me-2">
                    <?php
                    // Lista de roles válidos en tu sistema
                    $rolesValidos = ["Administrador", "Ayudante", "Veterinario", "Usuario", "Publicista", "Invitado"];

                    // Si el rol actual está vacío o no está en la lista, mostrarlo como opción seleccionada
                    if (empty($row['rol']) || !in_array($row['rol'], $rolesValidos)) {
                      echo "<option value='' selected>-- Sin rol asignado --</option>";
                    }

                    // Mostrar todas las opciones válidas
                    foreach ($rolesValidos as $rol) {
                      $selected = ($row['rol'] === $rol) ? "selected" : "";
                      echo "<option value='$rol' $selected>$rol</option>";
                    }
                    ?>
                  </select>

                  <button type="submit" class="btn btn-sm btn-outline-primary" title="Guardar rol">
                    <i class="bi bi-save fs-5"></i>
                  </button>
                </form>
              </td>
              <td>
                <?php if ($row['habilitado'] == 1): ?>
                  <span class="badge bg-success">Habilitado</span>
                <?php else: ?>
                  <span class="badge bg-danger">Deshabilitado</span>
                <?php endif; ?>
              </td>
              <td>
                <!-- Botón habilitar/deshabilitar -->
                <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/admin_toggleUsuario.php" method="post" class="d-inline">
                  <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                  <input type="hidden" name="habilitado" value="<?php echo $row['habilitado'] == 1 ? 0 : 1; ?>">
                  <button type="submit" class="btn btn-sm <?php echo $row['habilitado'] == 1 ? 'btn-danger' : 'btn-success'; ?>"
                    title="<?php echo $row['habilitado'] == 1 ? 'Deshabilitar' : 'Habilitar'; ?>">
                    <?php if ($row['habilitado'] == 1): ?>
                      <i class="bi bi-person-x fs-5"></i>
                    <?php else: ?>
                      <i class="bi bi-person-check fs-5"></i>
                    <?php endif; ?>
                  </button>
                </form>

                <!-- Botón editar -->
                <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/editarUsuario.php?id=<?php echo $row['idUsuario']; ?>"
                  class="btn btn-sm btn-primary" title="Editar usuario">
                  <i class="bi bi-pencil-square fs-5"></i>
                </a>

                <!-- Botón eliminar -->
                <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>admin_eliminar_usuario.php" method="post" class="d-inline"
                  onsubmit="return confirm('¿Seguro que desea eliminar este usuario?');">
                  <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger fs-5" title="Eliminar usuario">
                    <i class="bi bi-trash"></i>
                  </button>
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
  <?php require PUBLIC_PAGES_COMPONENTS . 'adm-phone-navbar.php'; ?>
</body>

</html>