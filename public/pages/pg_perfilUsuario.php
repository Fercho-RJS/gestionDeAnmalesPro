<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "perfil";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil | Comunidad de Animales</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body>
  <section id="ContenedorGeneral">
    <?php require PUBLIC_PAGES_COMPONENTS . 'marquee.php'; ?>
    <?php require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php'; ?>

    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">
                  <?php echo strtoupper($_SESSION['dni_persona']); ?>
                  <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                    <span class="badge text-bg-danger ms-2">Admin</span>
                  <?php } else if ($_SESSION['rol'] == 'Usuario') { ?>
                    <span class="badge text-bg-secondary ms-2">Usuario</span>
                  <?php } else if ($_SESSION['rol'] == 'Invitado') { ?>
                    <span class="badge text-bg-secondary ms-2">Visitante</span>
                  <?php } else if ($_SESSION['rol'] == 'Veterinario') { ?>
                    <span class="badge text-bg-success ms-2">Veterinario</span>
                  <?php } else if ($_SESSION['rol'] == 'Ayudante') { ?>
                    <span class="badge text-bg-warning ms-2">Ayudante</span>
                  <?php } else if ($_SESSION['rol'] == 'Publicista') { ?>
                    <span class="badge text-bg-primary ms-2">Publicista</span>
                  <?php } else { ?>
                    <span class="badge text-bg-dark ms-2">Sin rol</span>
                  <?php } ?>
                </h2>


                <!-- Botón para abrir modal -->
                <?php if ($_SESSION['rol'] != 'Invitado') { ?>
                  <div class="text-center mt-4">
                    <button class="btn btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
                      <i class="bi bi-pencil"></i>
                    </button>
                  </div>
                <?php } ?>

                <!-- Modal Editar Perfil -->
                <div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalEditarPerfilLabel">
                          <i class="bi bi-person-lines-fill me-2"></i> Editar Perfil
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                        <form action="<?php echo PUBLIC_PHP_FUNCTIONS_URL; ?>usuario/actualizar_perfil.php" method="post" class="row g-3 needs-validation" novalidate>

                          <div class="col-md-6">
                            <label for="dni" class="form-label fw-bold">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $_SESSION['dni_persona']; ?>" required>
                          </div>

                          <div class="col-md-6">
                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" required>
                          </div>

                          <div class="col-md-6">
                            <label for="apellido" class="form-label fw-bold">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $_SESSION['apellido']; ?>" required>
                          </div>

                          <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['user']; ?>" required>
                          </div>

                          <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $_SESSION['telefono']; ?>">
                          </div>

                          <div class="col-md-6">
                            <label for="direccion" class="form-label fw-bold">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $_SESSION['direccion']; ?>">
                          </div>

                          <div class="col-md-6">
                            <label for="calleAltura" class="form-label fw-bold">Altura</label>
                            <input type="text" class="form-control" id="calleAltura" name="calleAltura" value="<?php echo $_SESSION['calleAltura']; ?>">
                          </div>

                          <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-success rounded-pill px-5">
                              <i class="bi bi-check-circle me-2"></i> Guardar cambios
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <hr>

              <!-- Invitado -->
              <?php if ($_SESSION['rol'] == 'Invitado') { ?>
                <div class="alert alert-warning mt-4" role="alert">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  Para ver la información de su perfil, por favor inicie sesión.
                </div>
              <?php } else { ?>
                <!-- Información del usuario -->
                <h4 class="mt-3">Información del Usuario</h4>
                <ul class="list-group list-group-flush mt-3">
                  <!-- Foto de perfil -->
                  <div class="text-center mb-4">
                    <img src="https://i.imgur.com/8Km9tLL.png"
                      alt="Foto de perfil"
                      class="rounded-circle shadow-sm"
                      style="width: 220px; height: 220px; object-fit: cover; border: 4px solid #dee2e6;">
                  </div>

                  <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-2"></i>
                    <strong>DNI:</strong> <?php echo $_SESSION['dni_persona']; ?>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-person me-2"></i>
                    <strong>Nombre:</strong> <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-envelope me-2"></i>
                    <strong>Correo Electrónico:</strong> <?php echo $_SESSION['user']; ?>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-telephone me-2"></i>
                    <strong>Teléfono:</strong> <?php echo $_SESSION['telefono']; ?>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-geo-alt me-2"></i>
                    <strong>Dirección:</strong> <?php echo $_SESSION['direccion'] . ' ' . $_SESSION['calleAltura']; ?>
                  </li>
                </ul>

                <!-- Panel de administración -->
                <?php if ($_SESSION['rol'] === 'Administrador') { ?>
                  <div class="mt-4 text-center">
                    <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/admin/pg_adm_workspace.php"
                      class="btn btn-danger rounded-pill px-4">
                      <i class="bi bi-speedometer2 me-1"></i> Ir al Panel de Administración
                    </a>
                  </div>
                <?php } ?>
              <?php } ?>

              <!-- Botón cambiar contraseña -->
              <div class="mt-3 text-center">
                <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_cambiarPassword.php"
                  class="btn btn-link text-decoration-none">
                  <i class="bi bi-key me-2"></i> Cambiar contraseña
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    if ($_SESSION['rol'] == 'Usuario' || $_SESSION['rol'] == 'Invitado') {
      require PUBLIC_PAGES_COMPONENTS . 'prohibir_inspeccionar_elemento.php';
    }
    require PUBLIC_PAGES_COMPONENTS . 'footer.php';
    require PUBLIC_PAGES_COMPONENTS . 'support.php';
    ?>
  </section>
  <?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>

</html>