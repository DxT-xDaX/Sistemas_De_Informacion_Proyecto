<?php
require __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $confirmar = $_POST['confirmar'];

    // Validar que las contraseñas coincidan
    if ($clave !== $confirmar) {
        header("Location: /views/registrar_usuario.html?error=pass_mismatch");
        exit();
    }

    // Verificar si el usuario ya existe
    $stmt = $conexion->prepare("SELECT id_persona FROM personas WHERE usuario = ? OR correo = ?");
    $stmt->bind_param("ss", $usuario, $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: /views/registrar_usuario.html?error=user_exists");
        exit();
    }
    $stmt->close();

    // Obtener el último ID para generar uno nuevo
    $result = $conexion->query("SELECT MAX(id_persona) as max_id FROM personas");
    $row = $result->fetch_assoc();
    $nuevo_id = ($row['max_id'] ?? 0) + 1;

    // Hash de la contraseña
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO personas (id_persona, nombre, contrasena, usuario, correo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $nuevo_id, $nombre, $clave_hash, $usuario, $correo);

    if ($stmt->execute()) {
        header("Location: /?registro=exitoso");
        exit();
    } else {
        header("Location: /views/registrar_usuario.html?error=db_error");
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
