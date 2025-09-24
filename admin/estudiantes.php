<?php
require_once '../config/db.php';
require_once '../config/session.php';
verificarAutenticacion();

// Paginación
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Búsqueda y filtros
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$colegio_id = isset($_GET['colegio_id']) ? (int)$_GET['colegio_id'] : 0;

$whereConditions = [];
$params = [];

if (!empty($search)) {
    $whereConditions[] = "(e.nombre_completo LIKE ? OR e.documento LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($colegio_id > 0) {
    $whereConditions[] = "e.colegio_id = ?";
    $params[] = $colegio_id;
}

$whereSQL = '';
if (!empty($whereConditions)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereConditions);
}

// Obtener estudiantes
$sql = "SELECT e.*, c.nombre as colegio_nombre 
        FROM estudiantes e 
        LEFT JOIN colegios c ON e.colegio_id = c.id 
        $whereSQL 
        ORDER BY e.fecha_registro DESC 
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$estudiantes = $stmt->fetchAll();

// Contar total para paginación
$countSql = "SELECT COUNT(*) as total FROM estudiantes e $whereSQL";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$totalEstudiantes = $stmt->fetch()['total'];
$totalPages = ceil($totalEstudiantes / $limit);

// Obtener colegios para filtro
$colegios = $pdo->query("SELECT * FROM colegios WHERE activo = TRUE")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes - Conexión Vocacional</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <img src="../assets/img/logo-sena.png" alt="Logo SENA" class="logo">
            <h1>Panel Administrador</h1>
            <div class="admin-user">
                <span>Hola, <?php echo htmlspecialchars($_SESSION['admin_nombre']); ?></span>
                <a href="../logout.php" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="active"><a href="estudiantes.php">Gestión de Estudiantes</a></li>
                    <li><a href="programas.php">Gestión de Programas</a></li>
                    <li><a href="colegios.php">Gestión de Colegios</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <h2>Gestión de Estudiantes</h2>

                <!-- Filtros y búsqueda -->
                <div class="filters-section">
                    <form method="GET" class="filter-form">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" name="search" placeholder="Buscar por nombre o documento" 
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="form-group">
                                <select name="colegio_id">
                                    <option value="0">Todos los colegios</option>
                                    <?php foreach ($colegios as $colegio): ?>
                                    <option value="<?php echo $colegio['id']; ?>" 
                                        <?php echo $colegio_id == $colegio['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($colegio['nombre']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="estudiantes.php" class="btn btn-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla de estudiantes -->
                <div class="table-container">
                    <?php if (count($estudiantes) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th>Colegio</th>
                                <th>Grado</th>
                                <th>Teléfono</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $estudiante): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($estudiante['nombre_completo']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['documento']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['colegio_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['grado']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['telefono']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($estudiante['fecha_registro'])); ?></td>
                                <td>
                                    <button class="btn btn-small ver-detalles" 
                                            data-id="<?php echo $estudiante['id']; ?>">Ver</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&colegio_id=<?php echo $colegio_id; ?>" 
                               class="<?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                    <?php else: ?>
                    <p>No se encontraron estudiantes.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para detalles del estudiante -->
    <div id="modal-estudiante" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <footer class="admin-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> SENA - Conexión Vocacional. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../assets/js/admin.js"></script>
</body>
</html>