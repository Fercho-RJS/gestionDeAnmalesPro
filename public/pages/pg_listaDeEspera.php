<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
$_SESSION['pgActual'] = "listaDeEspera";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comunidad - Lista de Espera</title>
  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-navbar.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-support.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section id="ContenedorGeneral">
  <?php
  require PUBLIC_PAGES_COMPONENTS . 'marquee.php';
  require PUBLIC_PAGES_COMPONENTS . 'com_navbar.php';
  ?>

  <div class="container my-5">
    <div class="row">
      <div class="col-xl-6 col-lg-auto">
        <h1><b>Lista de Espera</b> — Mascotas pendientes</h1>
      </div>
    </div>
    <hr>

    <?php
    require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php'; // $conexion (mysqli)

    $idUsuario = (int)($_SESSION['idUsuario'] ?? 0);

    // Consulta corregida: toma nombre y apellido desde persona
    $sql = "SELECT 
              m.*,
              per.nombre   AS nombre_usuario,
              per.apellido AS apellido_usuario
            FROM mascota m
            INNER JOIN usuario u ON m.Usuario_idUsuario = u.idUsuario
            INNER JOIN persona per ON u.Persona_idPersona = per.idPersona
            WHERE m.Usuario_idUsuario = ? AND m.status = 'Pendiente'
            ORDER BY m.nombre ASC";

    $stmt = $conexion->prepare($sql);
    if ($stmt === false) {
      die("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("i", $idUsuario);
    if (!$stmt->execute()) {
      die("Error en execute: " . $stmt->error);
    }

    $resultado = $stmt->get_result();
    $mascotas = [];
    if ($resultado) {
      while ($fila = $resultado->fetch_assoc()) {
        $mascotas[] = $fila;
      }
    }
    $stmt->close();
    ?>

    <?php if (count($mascotas) > 0): ?>
      <div class="row g-4">
        <?php foreach ($mascotas as $mascota): ?>
          <div class="col-12">
            <div class="card shadow-sm rounded-4 d-flex flex-row align-items-start p-3 h-100">
              <div class="flex-shrink-0 me-3">
                <img src="<?php echo htmlspecialchars($mascota['imagen']); ?>"
                     alt="Imagen de mascota"
                     class="rounded-4"
                     style="width: 140px; height: 140px; object-fit: cover;">
              </div>

              <div class="flex-grow-1 small">
                <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($mascota['nombre']); ?></h5>
                <p class="mb-1"><b>Categoría:</b> <?php echo htmlspecialchars($mascota['categoria']); ?></p>
                <p class="mb-1"><b>Raza:</b> <?php echo htmlspecialchars($mascota['raza']); ?></p>
                <p class="mb-1"><b>Edad:</b> <?php echo htmlspecialchars($mascota['edad']); ?> Año/s</p>
                <p class="mb-1"><b>Color/es:</b> <?php echo htmlspecialchars($mascota['color']); ?></p>
                <p class="mb-2"><b>Tamaño:</b> <?php echo htmlspecialchars($mascota['height']); ?></p>

                <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="btn btn-sm btn-warning rounded-pill px-3">
                    <?php echo htmlspecialchars($mascota['status']); ?>
                  </span>
                  <a href="<?php echo PUBLIC_PAGES_URL; ?>workspace/animals/action/confirmar-encuentro.php?idMascota=<?php echo (int)$mascota['idMascota']; ?>"
                     class="btn btn-sm btn-outline-success rounded-pill px-3">
                    Confirmar Encuentro
                  </a>
                </div>

                <p class="mt-3 mb-0">
                  <b>Propietario:</b>
                  <?php echo htmlspecialchars(($mascota['nombre_usuario'] ?? '') . " " . ($mascota['apellido_usuario'] ?? '')); ?>
                </p>
                <p class="mb-0"><b>CID:</b> <?php echo htmlspecialchars($mascota['chipNro']); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-dark" role="alert">
        No tienes mascotas en lista de espera.
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
