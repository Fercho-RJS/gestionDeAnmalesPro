<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
require_once PUBLIC_PHP_FUNCTIONS . 'conectar-bdd.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Vacunas_idVacunas   = $_POST['Vacunas_idVacunas'] ?? null;
    $Mascota_idMascota   = $_POST['Mascota_idMascota'] ?? null;
    $veterinario         = $_POST['veterinario'] ?? '';
    $fecha_elaboracion   = $_POST['fecha_elaboracion'] ?? null;
    $numero_serie        = $_POST['numero_serie'] ?? '';
    $fecha_caducidad     = $_POST['fecha_caducidad'] ?? null;
    $proxima_dosis       = !empty($_POST['proxima_dosis']) ? $_POST['proxima_dosis'] : null;

    // Validación básica
    if (!$Vacunas_idVacunas || !$Mascota_idMascota) {
        header("Location: " . PUBLIC_PAGES_URL . "pg_asignarVacunacion.php?m=error");
        exit();
    }

    $sql = "INSERT INTO vacunas_mascota 
              (Vacunas_idVacunas, Mascota_idMascota, veterinario, fecha_elaboracion, numero_serie, fecha_caducidad, proxima_dosis)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "iisssss",
        $Vacunas_idVacunas,
        $Mascota_idMascota,
        $veterinario,
        $fecha_elaboracion,
        $numero_serie,
        $fecha_caducidad,
        $proxima_dosis
    );

    if ($stmt->execute()) {
        header("Location: " . PUBLIC_PAGES_URL . "pg_vacunasMascota.php?m=ok");
    } else {
        header("Location: " . PUBLIC_PAGES_URL . "pg_asignarVacunacion.php?m=error");
    }
    $stmt->close();
}
?>
