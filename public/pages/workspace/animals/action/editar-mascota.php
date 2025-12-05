<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_login.php?m=401");
    exit("No autenticado.");
}

$idUsuario = (int)$_SESSION['idUsuario'];

// Captura de datos del formulario
$idMascota   = (int)($_POST['idMascota'] ?? 0);
$nombre      = trim($_POST['nombre'] ?? '');
$categoria   = trim($_POST['categoria'] ?? '');
$raza        = trim($_POST['raza'] ?? '');
$edad        = (int)($_POST['edad'] ?? 0);
$color       = trim($_POST['color'] ?? '');
$height      = trim($_POST['height'] ?? '');

// Validación mínima
if ($idMascota <= 0 || $nombre === '' || $categoria === '') {
    header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=missing_fields");
    exit("Campos obligatorios faltantes.");
}

// Imagen subida
$rutaBD = null;
if (isset($_FILES['imagenMascota']) && $_FILES['imagenMascota']['error'] === UPLOAD_ERR_OK) {
    $directorioFisico  = $_SERVER['DOCUMENT_ROOT'] . "/public/res/animal_profiles/";
    $directorioPublico = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL;

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0777, true);
    }

    $nombreArchivo = 'mascota-' . $idMascota . '-' . time() . '-' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES['imagenMascota']['name']));
    $rutaCompleta  = $directorioFisico . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagenMascota']['tmp_name'], $rutaCompleta)) {
        $rutaBD = $directorioPublico . $nombreArchivo;
    }
}

$conexion->begin_transaction();

try {
    // Verificar que la mascota pertenece al usuario
    $verificar = $conexion->prepare("SELECT idMascota FROM mascota WHERE idMascota = ? AND Usuario_idUsuario = ? LIMIT 1");
    $verificar->bind_param("ii", $idMascota, $idUsuario);
    $verificar->execute();
    $verificar->store_result();
    if ($verificar->num_rows === 0) {
        $verificar->close();
        throw new RuntimeException("Mascota no encontrada o no pertenece al usuario.");
    }
    $verificar->close();

    // Actualizar mascota
    if ($rutaBD) {
        $sql = "UPDATE mascota SET nombre = ?, categoria = ?, raza = ?, edad = ?, color = ?, height = ?, imagen = ? WHERE idMascota = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssiissi", $nombre, $categoria, $raza, $edad, $color, $height, $rutaBD, $idMascota);
    } else {
        $sql = "UPDATE mascota SET nombre = ?, categoria = ?, raza = ?, edad = ?, color = ?, height = ? WHERE idMascota = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssiisi", $nombre, $categoria, $raza, $edad, $color, $height, $idMascota);
    }

    if ($stmt === false) {
        throw new RuntimeException("Error en prepare UPDATE: " . $conexion->error);
    }

    $stmt->execute();
    $stmt->close();

    $conexion->commit();

    header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=mascota_editada");
    exit();

} catch (Throwable $e) {
    $conexion->rollback();
    error_log("Error editar-mascota: " . $e->getMessage());
    header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=500");
    exit("Error interno: " . $e->getMessage());
} finally {
    if ($conexion && $conexion->ping()) {
        $conexion->close();
    }
}
