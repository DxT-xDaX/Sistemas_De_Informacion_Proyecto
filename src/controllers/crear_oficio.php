<?php
session_start();
require __DIR__ . '/../config/conexion.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: /");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_oficio = $_POST['num_oficio'];
    $persona = $_POST['persona'];
    $area = $_POST['area'];
    $asunto = $_POST['asunto'];
    $fecha = $_POST['fecha'];

    // Generar hash para integridad del documento
    $datos_hash = $num_oficio . $persona . $area . $asunto . $fecha;
    $hash = hash('sha256', $datos_hash);

    // Verificar si el número de oficio ya existe
    $stmt = $conexion->prepare("SELECT num_oficio FROM oficios WHERE num_oficio = ?");
    $stmt->bind_param("i", $num_oficio);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: /views/registrar.html?error=oficio_existe");
        exit();
    }
    $stmt->close();

    // Insertar nuevo oficio
    $stmt = $conexion->prepare("INSERT INTO oficios (num_oficio, persona, area, asunto, fecha, hash) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $num_oficio, $persona, $area, $asunto, $fecha, $hash);

    if ($stmt->execute()) {
        header("Location: /views/mostrartablas.php?success=oficio_creado");
        exit();
    } else {
        header("Location: /views/registrar.html?error=db_error");
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
