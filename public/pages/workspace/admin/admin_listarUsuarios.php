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
$sql = "SELECT  u.idUsuario, u.rol, u.habilitado, u.photo,
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
  <!-- Bootstrap JS (bundle con Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'adm_navbar.php'; ?>
    <div class="container-fluid my-4">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="card shadow-sm">
            <div class="card-body ">
              <div class="table-responsive rounded">
                <table class="table table-striped table-hover align-middle small">
                  <thead class="table-dark">
                    <tr>
                      <th>ID</th>
                      <th>Foto</th>
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
                      <?php
                      $rutaDefault = PUBLIC_RESOURCES_URL . "user_profiles/defaultuser.png";
                      $fotoPerfil  = $row['photo'] ?? '';
                      $mostrarFoto = (!empty($fotoPerfil) && file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($fotoPerfil, PHP_URL_PATH)))
                        ? $fotoPerfil
                        : $rutaDefault;
                      ?>
                      <tr>
                        <td><?php echo $row['idUsuario']; ?></td>
                        <td>
                          <img src="<?php echo $mostrarFoto; ?>"
                            alt="Foto de perfil"
                            class="rounded-circle border"
                            style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['dni']); ?></td>
                        <td>
                          <!-- Formulario rol -->
                          <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/admin_updateRol.php" method="post" class="d-flex align-items-center">
                            <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                            <select name="rol" class="form-select form-select-sm me-2">
                              <?php
                              $rolesValidos = ["Administrador", "Ayudante", "Veterinario", "Usuario", "Publicista", "Invitado"];
                              if (empty($row['rol']) || !in_array($row['rol'], $rolesValidos)) {
                                echo "<option value='' selected>-- Sin rol asignado --</option>";
                              }
                              foreach ($rolesValidos as $rol) {
                                $selected = ($row['rol'] === $rol) ? "selected" : "";
                                echo "<option value='$rol' $selected>$rol</option>";
                              }
                              ?>
                            </select>
                            <button type="submit" class="btn btn-sm rounded-circle btn-outline-primary" title="Guardar rol">
                              <i class="bi bi-save"></i>
                            </button>
                          </form>
                        </td>
                        <td>
                          <?php if ($row['habilitado'] == 1): ?>
                            <span class="badge bg-success rounded-pill">Habilitado</span>
                          <?php else: ?>
                            <span class="badge bg-danger rounded-pill">Deshabilitado</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <!-- Botones acciones -->
                          <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/admin_toggleUsuario.php" method="post" class="d-inline">
                            <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                            <input type="hidden" name="habilitado" value="<?php echo $row['habilitado'] == 1 ? 0 : 1; ?>">
                            <button type="submit" class="btn btn-sm rounded-circle <?php echo $row['habilitado'] == 1 ? 'btn-danger' : 'btn-success'; ?>"
                              title="<?php echo $row['habilitado'] == 1 ? 'Deshabilitar' : 'Habilitar'; ?>">
                              <?php if ($row['habilitado'] == 1): ?>
                                <i class="bi bi-person-x"></i>
                              <?php else: ?>
                                <i class="bi bi-person-check"></i>
                              <?php endif; ?>
                            </button>
                          </form>
                          <!-- Botón editar con modal -->
                          <button type="button"
                            class="btn btn-sm rounded-circle btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditar<?php echo $row['idUsuario']; ?>">
                            <i class="bi bi-pencil-square"></i>
                          </button>

                          <!-- Modal Editar Usuario -->
                          <div class="modal fade" id="modalEditar<?php echo $row['idUsuario']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/updateUsuario.php" method="post">
                                  <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title">Editar Usuario #<?php echo $row['idUsuario']; ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">

                                    <div class="row mb-3">
                                      <div class="col-md-6">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($row['apellido']); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="form-label">DNI</label>
                                        <input type="text" name="dni" class="form-control" value="<?php echo htmlspecialchars($row['dni']); ?>">
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-6">
                                        <label class="form-label">Rol</label>
                                        <select name="rol" class="form-select">
                                          <?php
                                          $rolesValidos = ["Administrador", "Ayudante", "Veterinario", "Usuario", "Publicista", "Invitado"];
                                          foreach ($rolesValidos as $rol) {
                                            $selected = ($row['rol'] === $rol) ? "selected" : "";
                                            echo "<option value='$rol' $selected>$rol</option>";
                                          }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="form-label">Estado</label>
                                        <select name="habilitado" class="form-select">
                                          <option value="1" <?php echo $row['habilitado'] == 1 ? "selected" : ""; ?>>Habilitado</option>
                                          <option value="0" <?php echo $row['habilitado'] == 0 ? "selected" : ""; ?>>Deshabilitado</option>
                                        </select>
                                      </div>
                                      <div class="row mt-3">
                                        <div class="col-md-6">
                                          <label class="form-label">Nueva contraseña</label>
                                          <input type="password" name="password" class="form-control" placeholder="Dejar vacío para no cambiar">
                                          <small class="text-muted">Si la dejás vacía, la contraseña actual se mantiene.</small>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                          <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" name="resetPassword" value="1" id="reset<?php echo $row['idUsuario']; ?>">
                                            <label class="form-check-label" for="reset<?php echo $row['idUsuario']; ?>">
                                              Blanquear contraseña
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>


                          <form action="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/usuario/deleteUsuario.php" method="post" class="d-inline"
                            onsubmit="return confirm('¿Seguro que desea eliminar este usuario?');">
                            <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario']; ?>">
                            <button type="submit" class="btn btn-sm rounded-circle btn-outline-danger" title="Eliminar usuario">
                              <i class="bi bi-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'adm-phone-navbar.php'; ?>

</body>

</html>