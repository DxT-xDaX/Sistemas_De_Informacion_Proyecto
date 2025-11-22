<?php
// Configuración de conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "dzb7Wz538C";
$basedatos = "sistemas_info";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");
?>
