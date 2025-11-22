<?php
session_start();
require __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Preparar consulta para evitar SQL injection
    $stmt = $conexion->prepare("SELECT id_persona, usuario, contrasena FROM personas WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        // Verificar contraseña (asumiendo que está hasheada con password_hash)
        if (password_verify($clave, $row['contrasena'])) {
            // Login exitoso
            $_SESSION['id_persona'] = $row['id_persona'];
            $_SESSION['usuario'] = $row['usuario'];
            header("Location: /views/mostrartablas.php");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: /?error=1");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: /?error=1");
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
