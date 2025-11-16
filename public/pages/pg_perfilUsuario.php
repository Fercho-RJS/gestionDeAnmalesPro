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
                  <?php } ?>
                </h2>
                <?php if ($_SESSION['rol'] != 'Invitado') { ?>
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>pg_editarPerfil.php"
                    class="btn btn-outline-secondary btn-sm rounded-circle" title="Editar perfil">
                    <i class="bi bi-pencil"></i>
                  </a>
                <?php } ?>
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
</body>

</html>