<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Oficios - Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f7fa;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      min-height: 100vh;
    }
    .header {
      background-color: #2c3e50;
      color: white;
      padding: 20px 0;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .header h1 {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
    }
    .header .btn-logout {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 0.9rem;
    }
    .header .btn-logout:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }
    .main-content {
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 20px;
    }
    .content-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 30px;
    }
    .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 8px;
    }
    .page-subtitle {
      color: #7f8c8d;
      font-size: 0.95rem;
      margin-bottom: 25px;
    }
    .action-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      flex-wrap: wrap;
      gap: 15px;
    }
    .btn-action {
      padding: 10px 20px;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      border: none;
      transition: all 0.2s;
    }
    .btn-new { background-color: #27ae60; color: white; }
    .btn-new:hover { background-color: #229954; }
    .btn-edit { background-color: #f39c12; color: white; }
    .btn-edit:hover { background-color: #d68910; }
    .btn-delete { background-color: #e74c3c; color: white; }
    .btn-delete:hover { background-color: #c0392b; }
    .btn-search { background-color: #3498db; color: white; }
    .btn-search:hover { background-color: #2980b9; }
    .table-container {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }
    thead {
      background-color: #f8f9fa;
      border-bottom: 2px solid #dfe4ea;
    }
    thead th {
      padding: 15px;
      text-align: left;
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    tbody tr {
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.2s;
    }
    tbody tr:hover {
      background-color: #f8f9fa;
    }
    tbody td {
      padding: 15px;
      color: #2c3e50;
      font-size: 0.95rem;
    }
    .hash-cell {
      font-family: 'Courier New', monospace;
      font-size: 0.8rem;
      color: #7f8c8d;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
    }
    .empty-state i {
      font-size: 4rem;
      color: #dfe4ea;
      margin-bottom: 20px;
    }
    .empty-state h3 {
      color: #7f8c8d;
      font-weight: 600;
      margin-bottom: 10px;
    }
    .empty-state p {
      color: #95a5a6;
      margin-bottom: 20px;
    }
    .record-count {
      background-color: #ecf0f1;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      color: #2c3e50;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        <h1><i class="bi bi-file-earmark-text me-2"></i>Sistema de Gestión de Oficios</h1>
      </div>
      <a href="/" class="btn btn-logout">
        <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
      </a>
    </div>
  </header>

<?php
require __DIR__ . '/../config/conexion.php';
mysqli_set_charset($conexion,'utf8');

$consulta_sql="SELECT * FROM oficios ORDER BY num_oficio DESC";
$resultado = $conexion->query($consulta_sql);
$count = mysqli_num_rows($resultado);
?>

  <div class="main-content">
    <div class="content-card">
      <h2 class="page-title">Lista de Oficios</h2>
      <p class="page-subtitle">Gestione y consulte los oficios registrados en el sistema</p>

      <div class="action-bar">
        <div>
          <span class="record-count">
            <i class="bi bi-list-ul me-1"></i><?php echo $count; ?> registro<?php echo $count != 1 ? 's' : ''; ?>
          </span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          <a href="/views/registrar.html" class="btn btn-action btn-new">
            <i class="bi bi-plus-circle me-1"></i>Nuevo
          </a>
          <a href="/views/editar.html" class="btn btn-action btn-edit">
            <i class="bi bi-pencil me-1"></i>Editar
          </a>
          <a href="/views/eliminar.html" class="btn btn-action btn-delete">
            <i class="bi bi-trash me-1"></i>Eliminar
          </a>
          <a href="/views/consultar.php" class="btn btn-action btn-search">
            <i class="bi bi-search me-1"></i>Consultar
          </a>
        </div>
      </div>

      <div class="table-container">
        <?php if ($count > 0): ?>
        <table>
          <thead>
            <tr>
              <th>Nº Oficio</th>
              <th>Persona</th>
              <th>Área</th>
              <th>Asunto</th>
              <th>Fecha</th>
              <th>Hash</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($resultado)): ?>
            <tr>
              <td><strong><?php echo $row['num_oficio']; ?></strong></td>
              <td><?php echo htmlspecialchars($row['persona']); ?></td>
              <td><?php echo htmlspecialchars($row['area']); ?></td>
              <td><?php echo htmlspecialchars($row['asunto']); ?></td>
              <td><?php echo htmlspecialchars($row['fecha']); ?></td>
              <td class="hash-cell" title="<?php echo $row['hash']; ?>">
                <?php echo substr($row['hash'], 0, 12) . '...'; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
          <i class="bi bi-inbox"></i>
          <h3>No hay registros</h3>
          <p>No se encontraron oficios en el sistema</p>
          <a href="/views/registrar.html" class="btn btn-action btn-new">
            <i class="bi bi-plus-circle me-2"></i>Crear Primer Oficio
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>
</html>
