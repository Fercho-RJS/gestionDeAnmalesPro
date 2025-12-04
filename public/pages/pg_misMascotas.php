<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "misMascotas";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad - Mis Mascotas</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>

  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
</head>

<body>
  <section id="ContenedorGeneral">

    <?php
    require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
    require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
    ?>

    <section class="m-5">
      <div class="row">
        <div class="col-xl-6 col-lg-auto">
          <p>Mascotas de <b><?php echo strtoupper($_SESSION['user']); ?></b></p>
        </div>
        <div class="col-xl-6 col-lg-auto text-end">
          <a id="new_mascota"
            <?php echo ($_SESSION['rol'] == 'Invitado')
              ? 'href=""'
              : 'href="' . PUBLIC_PAGES_URL . 'workspace/animals/forms/newMascotaType.php"'; ?>
            class="btn btn-sm rounded-pill btn-success px-3">Registrar</a>
        </div>
      </div>
      <hr>

      <?php
      require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php'; // define $conexion (mysqli)

      $idUsuario = $_SESSION['idUsuario'] ?? 0;

      $sql = "SELECT *, mascota.nombre AS nombre_mascota 
            FROM mascota, usuario, persona 
            WHERE usuario.Persona_idPersona = persona.idPersona 
              AND mascota.Usuario_idUsuario = usuario.idUsuario 
              AND usuario.idUsuario = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("i", $idUsuario);
      $stmt->execute();
      $resultado = $stmt->get_result();

      $mascotas = [];
      while ($mascota = $resultado->fetch_assoc()) {
        $mascotas[] = $mascota;
      }
      ?>

      <?php if (count($mascotas) > 0): ?>
        <div class="row g-4">
          <?php foreach ($mascotas as $mascota): ?>
            <div class="col-12 col-md-6 mb-2 d-flex tarjeta_mascota">
              <div class="row border p-3 rounded-3 w-100 align-items-center">
                <div class="col-12 col-sm-auto text-center mb-3 mb-sm-0">
                  <img class="img-fluid rounded-4"
                    style="height: 220px; object-fit: cover; width: 220px; max-width: 100%;"
                    src="<?php echo $mascota['imagen']; ?>"
                    alt="Imagen de mascota">
                </div>
                <div class="col-12 col-sm d-flex">
                  <div class="align-content-center w-100" style="min-width: 0;">
                    <h2 class="fw-bold"><?php echo htmlspecialchars($mascota['nombre_mascota']); ?></h2>
                    <article class="small">
                      <p class="mb-0"><b>Categoría: </b><?php echo htmlspecialchars($mascota['categoria']); ?></p>
                      <p class="mb-0"><b>Raza: </b><?php echo htmlspecialchars($mascota['raza']); ?></p>
                      <p class="mb-0"><b>Edad: </b><?php echo htmlspecialchars($mascota['edad']); ?> Año/s</p>
                      <p class="mb-0"><b>Color/es de Identidad: </b><?php echo htmlspecialchars($mascota['color']); ?></p>
                      <p class="mb-0"><b>Altura / Tamaño: </b><?php echo htmlspecialchars($mascota['height']); ?></p>
                    </article>

                    <div>
                      <div class="d-flex gap-0 flex-wrap">
                        <a onclick="cambiar_estado(<?php echo $mascota['idMascota']; ?>)"
                          class="mb-0 mt-3 w-50 btn btn-sm p-0 rounded-pill 
                         <?php if ($mascota['status'] == 'Adoptado') echo 'btn-success'; ?>
                         <?php if ($mascota['status'] == 'Perdido') echo 'btn-danger'; ?>
                         <?php if ($mascota['status'] == 'En adopción') echo 'btn-warning'; ?> col-8">
                          <?php echo htmlspecialchars($mascota['status']); ?>
                        </a>
                        <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/form_edit_animal.php?id=<?php echo $mascota['idMascota']; ?>"
                          class="btn btn-outline-dark w-25 ms-2 mt-3 btn-sm p-0 rounded-pill">Editar</a>
                        <button onclick="capturarTarjeta(this)" class="btn btn-sm btn-outline-primary mt-2 w-100">Capturar como imagen</button>
                      </div>
                    </div>
                    <p class="mt-3 small"><b>Propietario </b> <?php echo $mascota['nombre'] . " " . $mascota['apellido']; ?></p>
                    <p class="mt-3 small"><b>CID
                        <button type="button" class="btn btn-dark btn-sm m-0 px-2 py-0 rounded-circle"
                          data-bs-toggle="tooltip" data-bs-placement="top"
                          data-bs-title="Codigo de Identificación & Seguimiento">?</button>
                      </b><?php echo htmlspecialchars($mascota['chipNro']); ?></p>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-dark" role="alert">
          No posees mascotas registradas.
        </div>
      <?php endif; ?>
    </section>

    <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
    <?php
    if ($_SESSION['rol'] == 'Usuario' || $_SESSION['rol'] == 'Invitado') {
      require PUBLIC_PAGES_COMPONENTS . 'prohibir_inspeccionar_elemento.php';
    }
    require PUBLIC_PAGES_COMPONENTS . 'footer.php';
    require PUBLIC_PAGES_COMPONENTS . 'support.php';
    ?>

    <?php if ($_SESSION['rol'] == 'Invitado') { ?>
      <script>
        $(document).ready(function() {
          $('#new_mascota').on("click", function(e) {
            e.preventDefault();
            Swal.fire({
              title: 'Acceso bloqueado',
              text: 'Debes registrar una cuenta para asociar/registrar una mascota a tu perfil.',
              icon: 'warning',
              confirmButtonText: 'Entendido'
            });
          });
        });
      </script>
    <?php } ?>
  </section>

  <script>
    function cambiar_estado(idMascota) {
      const estados = ['Adoptado', 'Perdido', 'En adopción'];
      let selectHTML = '<select id="nuevoEstado" class="form-select">';
      estados.forEach(estado => {
        selectHTML += `<option value="${estado}">${estado}</option>`;
      });
      selectHTML += '</select>';

      Swal.fire({
        title: 'Cambiar estado de la mascota',
        html: selectHTML,
        showCancelButton: true,
        confirmButtonText: 'Cambiar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => document.getElementById('nuevoEstado').value
      }).then((result) => {
        if (result.isConfirmed) {
          const nuevoEstado = result.value;
          window.location.href = "<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/cambiar-estado-animal.php?idMascota=" + idMascota + "&nuevoEstado=" + encodeURIComponent(nuevoEstado);
        }
      });
    }
  </script>

  <!-- Librería html2canvas -->
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

  <script>
    function capturarTarjeta(boton) {
      const tarjeta = boton.closest('.row.border'); // Captura la tarjeta específica

      // Ocultar todos los botones dentro de la tarjeta
      const botones = tarjeta.querySelectorAll('button, a');
      botones.forEach(btn => btn.classList.add('d-none'));

      html2canvas(tarjeta).then(canvas => {
        // Restaurar visibilidad
        botones.forEach(btn => btn.classList.remove('d-none'));

        // Descargar imagen
        const link = document.createElement('a');
        link.download = 'credencial-mascota.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      });
    }
  </script>
  <?php require PUBLIC_PAGES_COMPONENTS . 'com-phone-navbar.php'; ?>
</body>
</html>