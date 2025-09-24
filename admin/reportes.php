<?php
require_once '../config/db.php';
require_once '../config/session.php';
verificarAutenticacion();

// Obtener estadísticas generales
$total_estudiantes = $pdo->query("SELECT COUNT(*) as total FROM estudiantes")->fetch()['total'];
$total_programas = $pdo->query("SELECT COUNT(*) as total FROM programas WHERE activo = TRUE")->fetch()['total'];
$total_colegios = $pdo->query("SELECT COUNT(*) as total FROM colegios WHERE activo = TRUE")->fetch()['total'];

// Estudiantes por colegio
$estudiantes_por_colegio = $pdo->query("
    SELECT c.nombre as colegio, COUNT(e.id) as total_estudiantes
    FROM colegios c
    LEFT JOIN estudiantes e ON c.id = e.colegio_id
    WHERE c.activo = TRUE
    GROUP BY c.id
    ORDER BY total_estudiantes DESC
")->fetchAll();

// Programas más seleccionados
$programas_populares = $pdo->query("
    SELECT p.nombre as programa, COUNT(pr.id) as total_selecciones
    FROM programas p
    LEFT JOIN preferencias pr ON p.id = pr.programa_id
    WHERE p.activo = TRUE
    GROUP BY p.id
    ORDER BY total_selecciones DESC
    LIMIT 10
")->fetchAll();

// Estudiantes por grado
$estudiantes_por_grado = $pdo->query("
    SELECT grado, COUNT(*) as total
    FROM estudiantes
    GROUP BY grado
    ORDER BY grado
")->fetchAll();

// Fechas para filtros
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');

// Registros por fecha (con filtro)
$registros_por_fecha = $pdo->prepare("
    SELECT DATE(fecha_registro) as fecha, COUNT(*) as total
    FROM estudiantes
    WHERE fecha_registro BETWEEN ? AND ?
    GROUP BY DATE(fecha_registro)
    ORDER BY fecha DESC
");
$registros_por_fecha->execute([$fecha_inicio . ' 00:00:00', $fecha_fin . ' 23:59:59']);
$registros_por_fecha = $registros_por_fecha->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Conexión Vocacional</title>
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
                    <li><a href="estudiantes.php">Gestión de Estudiantes</a></li>
                    <li><a href="programas.php">Gestión de Programas</a></li>
                    <li><a href="colegios.php">Gestión de Colegios</a></li>
                    <li class="active"><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <h2>Reportes y Estadísticas</h2>

                <!-- Filtros -->
                <div class="filters-section">
                    <h3>Filtrar por Fecha</h3>
                    <form method="GET" class="filter-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin; ?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="reportes.php" class="btn btn-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Estadísticas generales -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Estudiantes</h3>
                        <p class="stat-number"><?php echo number_format($total_estudiantes); ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Programas Activos</h3>
                        <p class="stat-number"><?php echo number_format($total_programas); ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Colegios Activos</h3>
                        <p class="stat-number"><?php echo number_format($total_colegios); ?></p>
                    </div>
                </div>

                <!-- Estudiantes por colegio -->
                <div class="report-section">
                    <h3>Estudiantes por Colegio</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Colegio</th>
                                    <th>Total Estudiantes</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estudiantes_por_colegio as $colegio): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($colegio['colegio']); ?></td>
                                    <td><?php echo number_format($colegio['total_estudiantes']); ?></td>
                                    <td>
                                        <?php if ($total_estudiantes > 0): ?>
                                        <?php echo number_format(($colegio['total_estudiantes'] / $total_estudiantes) * 100, 1); ?>%
                                        <?php else: ?>
                                        0%
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Programas más populares -->
                <div class="report-section">
                    <h3>Programas Más Seleccionados</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Programa</th>
                                    <th>Total Selecciones</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_selecciones = 0;
                                foreach ($programas_populares as $programa) {
                                    $total_selecciones += $programa['total_selecciones'];
                                }
                                ?>
                                <?php foreach ($programas_populares as $programa): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($programa['programa']); ?></td>
                                    <td><?php echo number_format($programa['total_selecciones']); ?></td>
                                    <td>
                                        <?php if ($total_selecciones > 0): ?>
                                        <?php echo number_format(($programa['total_selecciones'] / $total_selecciones) * 100, 1); ?>%
                                        <?php else: ?>
                                        0%
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Estudiantes por grado -->
                <div class="report-section">
                    <h3>Estudiantes por Grado</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Grado</th>
                                    <th>Total Estudiantes</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estudiantes_por_grado as $grado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($grado['grado']); ?></td>
                                    <td><?php echo number_format($grado['total']); ?></td>
                                    <td>
                                        <?php if ($total_estudiantes > 0): ?>
                                        <?php echo number_format(($grado['total'] / $total_estudiantes) * 100, 1); ?>%
                                        <?php else: ?>
                                        0%
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Registros por fecha -->
                <div class="report-section">
                    <h3>Registros por Fecha (<?php echo $fecha_inicio; ?> al <?php echo $fecha_fin; ?>)</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Total Registros</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registros_por_fecha as $registro): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($registro['fecha'])); ?></td>
                                    <td><?php echo number_format($registro['total']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($registros_por_fecha) === 0): ?>
                                <tr>
                                    <td colspan="2">No hay registros en el período seleccionado</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botones de exportación -->
                <div class="export-actions">
                    <h3>Exportar Reportes</h3>
                    <div class="form-actions">
                        <button class="btn btn-primary" onclick="exportarPDF()">Exportar a PDF</button>
                        <button class="btn btn-primary" onclick="exportarExcel()">Exportar a Excel</button>
                        <button class="btn btn-secondary" onclick="imprimirReportes()">Imprimir</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="admin-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> SENA - Conexión Vocacional. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../assets/js/admin.js"></script>
    <script>
        function exportarPDF() {
            alert('Funcionalidad de exportación a PDF en desarrollo');
            // Aquí se implementaría la generación de PDF
        }

        function exportarExcel() {
            alert('Funcionalidad de exportación a Excel en desarrollo');
            // Aquí se implementaría la generación de Excel
        }

        function imprimirReportes() {
            window.print();
        }
    </script>
</body>
</html>