<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
// echo "</pre>";
// exit;
// Captura de datos del formulario
$nombre          = $_POST['nombre'] ?? null;
$tipo            = $_POST['tipo'] ?? null;
$colorList       = $_POST['colorList'] ?? null;
$fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
$raza            = $_POST['raza'] ?? null;
$fechaAdopcion   = $_POST['fechaAdopcion'] ?? null;
$tamanio         = $_POST['tamanio'] ?? null;
$chipNroInput    = $_POST['chipNro'] ?? null; // opcional
$propietario     = $_SESSION['idUsuario'] ?? null;

// Validación de campos obligatorios
if (empty($nombre) || empty($fechaNacimiento) || empty($raza) || empty($tipo) || empty($colorList) || empty($tamanio)) {
    header("Location: " . PUBLIC_PAGES_URL . "workspace/animals/newMascotaType.php?error=missing_fields");
    exit;
}

// Generar código único de chip si no se envió
if (!empty($chipNroInput)) {
    $codigoAnimal = $chipNroInput;
} else {
    do {
        $codigoAnimal = bin2hex(random_bytes(5));
        $stmtCheck = $conexion->prepare("SELECT chipNro FROM mascota WHERE chipNro = ?");
        $stmtCheck->bind_param("s", $codigoAnimal);
        $stmtCheck->execute();
        $resultado = $stmtCheck->get_result();
        $row = $resultado->fetch_assoc();
        $stmtCheck->close();
    } while ($row);
}

// Calcular edad aproximada
$edad = (int)date("Y") - (int)date("Y", strtotime($fechaNacimiento));

// Imagen por defecto
$rutaBD = PUBLIC_RESOURCES_IMAGES_URL . "animal.png";
// Si se sube una imagen personalizada
if (isset($_FILES['imagenUrl']) && $_FILES['imagenUrl']['error'] === UPLOAD_ERR_OK) {
    // Ruta física en servidor (htdocs/public/res/animal_profiles/)
    $directorioFisico = $_SERVER['DOCUMENT_ROOT'] . "/public/res/animal_profiles/";
    // Ruta pública para BD (ej: "/public/res/animal_profiles/")
    $directorioPublico = PUBLIC_RESOURCES_ANIMAL_PROFILES_URL;

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0777, true);
    }

    $nombreArchivo = 'photo-' . time() . '-' . basename($_FILES['imagenUrl']['name']);
    $rutaCompleta = $directorioFisico . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagenUrl']['tmp_name'], $rutaCompleta)) {
        $rutaBD = $directorioPublico . $nombreArchivo;
    } else {
        die("Error al mover archivo. Ruta: $rutaCompleta");
    }
}

// Insertar mascota con prepared statement
$sql = "INSERT INTO mascota 
        (nombre, categoria, raza, edad, color, height, imagen, chipNro, status, Usuario_idUsuario) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Adoptado', ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param(
    "sssissssi",
    $nombre,
    $tipo,
    $raza,
    $edad,
    $colorList,
    $tamanio,
    $rutaBD,
    $codigoAnimal,
    $propietario
);

if ($stmt->execute()) {
    header("Location: " . PUBLIC_PAGES_URL . "pg_misMascotas.php?m=mascota_registrada");
    exit;
} else {
    echo "Error al registrar la mascota: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
