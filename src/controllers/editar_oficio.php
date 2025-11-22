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

    // Generar nuevo hash para integridad
    $datos_hash = $num_oficio . $persona . $area . $asunto . $fecha;
    $hash = hash('sha256', $datos_hash);

    // Actualizar oficio
    $stmt = $conexion->prepare("UPDATE oficios SET persona = ?, area = ?, asunto = ?, fecha = ?, hash = ? WHERE num_oficio = ?");
    $stmt->bind_param("sssssi", $persona, $area, $asunto, $fecha, $hash, $num_oficio);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: /views/mostrartablas.php?success=oficio_actualizado");
        } else {
            header("Location: /views/editar.html?error=oficio_no_existe");
        }
        exit();
    } else {
        header("Location: /views/editar.html?error=db_error");
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
