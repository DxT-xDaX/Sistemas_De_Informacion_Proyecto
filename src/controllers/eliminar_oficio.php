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

    // Eliminar oficio
    $stmt = $conexion->prepare("DELETE FROM oficios WHERE num_oficio = ?");
    $stmt->bind_param("i", $num_oficio);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: /views/mostrartablas.php?success=oficio_eliminado");
        } else {
            header("Location: /views/eliminar.html?error=oficio_no_existe");
        }
        exit();
    } else {
        header("Location: /views/eliminar.html?error=db_error");
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
