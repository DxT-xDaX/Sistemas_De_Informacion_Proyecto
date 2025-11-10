<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Principal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Encabezado -->
  <header class="bg-primary text-white py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <h2>Gestión de Oficios</h2>
      <a href="index.html" class="btn btn-light btn-sm">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </a>
    </div>
  </header>


<?php
require "conexion.php";
mysqli_set_charset($conexion,'utf8');

$consulta_sql="SELECT * FROM oficios";

$resultado = $conexion->query($consulta_sql);

$count = mysqli_num_rows($resultado); 

echo '
    <main class="container my-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
      <h4 class="mb-2 mb-md-0">Lista de Oficios</h4>

      <!-- Barra de botones de acciones -->
      <div class="btn-group">
        <a href="registrar.html" class="btn btn-success">
          <i class="bi bi-file-earmark-plus"></i> Nuevo
        </a>
        <a href="editar.html" class="btn btn-warning">
          <i class="bi bi-pencil-square"></i> Editar
        </a>
        <a href="eliminar.html" class="btn btn-danger">
          <i class="bi bi-trash"></i> Eliminar
        </a>
        <a href="consultar.html" class="btn btn-info text-white">
          <i class="bi bi-search"></i> Consultar
        </a>
      </div>
    </div>

    <!-- Tabla de oficios -->
    <div class="table-responsive">
      <table class="table table-secondary table-striped table-hover align-middle text-center">
        <thead class="table-primary">
          <tr>
            <th scope="col">Número de Oficio</th>
            <th scope="col">Persona</th>
            <th scope="col">Área</th>
            <th scope="col">Asunto</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hash</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
';

if ( $count>0 ){
    //aqui se pintarian los registro de la DB
    while( $row = mysqli_fetch_assoc($resultado)  ){
     echo "<tr>";
     echo"<td>". $row['num_oficio'] ."</td>";
     echo"<td>". $row['persona'] ."</td>";
     echo"<td>". $row['area'] ."</td>";
     echo"<td>". $row['asunto'] ."</td>";
     echo"<td>". $row['fecha'] ."</td>";
     echo"<td>". $row['hash'] ."</td>";
     echo "</tr>";
    }
    echo "</table>";
}else{
    echo"<h1 style='color:red' >Sin Ningun registro</h1>";
    }
    ?>