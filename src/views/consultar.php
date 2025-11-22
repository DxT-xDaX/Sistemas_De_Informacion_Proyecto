<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Oficios - Sistema de Gestión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f7fa;
      min-height: 100vh;
      padding: 20px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    .container {
      max-width: 900px;
      margin: 0 auto;
    }
    .search-card {
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
    }
    .header-section h1 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 5px;
    }
    .header-section p {
      color: #7f8c8d;
      font-size: 0.9rem;
      margin-bottom: 25px;
    }
    .form-control {
      border: 1px solid #dfe4ea;
      padding: 12px 15px;
      border-radius: 6px;
      font-size: 0.95rem;
    }
    .form-control:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .btn-search {
      background-color: #3498db;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-weight: 500;
    }
    .btn-search:hover {
      background-color: #2980b9;
    }
    .btn-back {
      background-color: #95a5a6;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-weight: 500;
      text-decoration: none;
      display: inline-block;
    }
    .btn-back:hover {
      background-color: #7f8c8d;
      color: white;
    }
    .results-card {
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
    }
    tbody tr {
      border-bottom: 1px solid #f0f0f0;
    }
    tbody tr:hover {
      background-color: #f8f9fa;
    }
    tbody td {
      padding: 15px;
      color: #2c3e50;
      font-size: 0.95rem;
    }
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: #95a5a6;
    }
    .empty-state i {
      font-size: 3rem;
      margin-bottom: 15px;
      color: #dfe4ea;
    }
    .search-type {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    .search-type label {
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      color: #2c3e50;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="search-card">
      <div class="header-section">
        <h1><i class="bi bi-search me-2"></i>Consultar Oficios</h1>
        <p>Busque oficios por número, persona, área o asunto</p>
      </div>

      <form action="/views/consultar.php" method="GET">
        <div class="search-type">
          <label>
            <input type="radio" name="tipo" value="num_oficio" checked>
            Número
          </label>
          <label>
            <input type="radio" name="tipo" value="persona">
            Persona
          </label>
          <label>
            <input type="radio" name="tipo" value="area">
            Área
          </label>
          <label>
            <input type="radio" name="tipo" value="asunto">
            Asunto
          </label>
        </div>

        <div class="input-group mb-3">
          <input type="text" name="busqueda" class="form-control" placeholder="Ingrese el término de búsqueda..." required>
          <button type="submit" class="btn btn-search">
            <i class="bi bi-search me-1"></i>Buscar
          </button>
        </div>

        <a href="/views/mostrartablas.php" class="btn btn-back">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </a>
      </form>
    </div>

    <?php if (isset($_GET['busqueda'])): ?>
    <div class="results-card">
      <h5 class="mb-3">Resultados de búsqueda</h5>
      <?php
      require __DIR__ . '/../config/conexion.php';
      mysqli_set_charset($conexion,'utf8');

      $tipo = $_GET['tipo'];
      $busqueda = $_GET['busqueda'];

      // Validar tipo de búsqueda
      $campos_validos = ['num_oficio', 'persona', 'area', 'asunto'];
      if (!in_array($tipo, $campos_validos)) {
        $tipo = 'num_oficio';
      }

      // Preparar consulta según el tipo
      if ($tipo == 'num_oficio') {
        $stmt = $conexion->prepare("SELECT * FROM oficios WHERE num_oficio = ?");
        $stmt->bind_param("i", $busqueda);
      } else {
        $busqueda_like = "%$busqueda%";
        $stmt = $conexion->prepare("SELECT * FROM oficios WHERE $tipo LIKE ?");
        $stmt->bind_param("s", $busqueda_like);
      }

      $stmt->execute();
      $resultado = $stmt->get_result();
      $count = $resultado->num_rows;

      if ($count > 0):
      ?>
        <p class="text-muted mb-3">Se encontraron <?php echo $count; ?> resultado(s)</p>
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>Nº Oficio</th>
                <th>Persona</th>
                <th>Área</th>
                <th>Asunto</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $resultado->fetch_assoc()): ?>
              <tr>
                <td><strong><?php echo $row['num_oficio']; ?></strong></td>
                <td><?php echo htmlspecialchars($row['persona']); ?></td>
                <td><?php echo htmlspecialchars($row['area']); ?></td>
                <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha']); ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="bi bi-inbox"></i>
          <p>No se encontraron oficios con ese criterio</p>
        </div>
      <?php endif;
      $stmt->close();
      ?>
    </div>
    <?php endif; ?>
  </div>

</body>
</html>
