<?php
require_once '../config/db.php';
require_once '../config/session.php';
verificarAutenticacion();

// Obtener estadísticas
$total_estudiantes = $pdo->query("SELECT COUNT(*) as total FROM estudiantes")->fetch()['total'];
$total_programas = $pdo->query("SELECT COUNT(*) as total FROM programas WHERE activo = TRUE")->fetch()['total'];
$total_colegios = $pdo->query("SELECT COUNT(*) as total FROM colegios WHERE activo = TRUE")->fetch()['total'];

// Programas más populares
$programas_populares = $pdo->query("
    SELECT p.nombre, COUNT(pr.id) as selecciones 
    FROM programas p 
    LEFT JOIN preferencias pr ON p.id = pr.programa_id 
    WHERE p.activo = TRUE
    GROUP BY p.id 
    ORDER BY selecciones DESC 
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Conexión Vocacional</title>
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
                    <li class="active"><a href="index.php">Dashboard</a></li>
                    <li><a href="estudiantes.php">Gestión de Estudiantes</a></li>
                    <li><a href="programas.php">Gestión de Programas</a></li>
                    <li><a href="colegios.php">Gestión de Colegios</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <h2>Dashboard</h2>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Estudiantes Registrados</h3>
                        <p class="stat-number"><?php echo $total_estudiantes; ?></p>
                        <a href="estudiantes.php" class="btn btn-secondary">Ver todos</a>
                    </div>

                    <div class="stat-card">
                        <h3>Programas Activos</h3>
                        <p class="stat-number"><?php echo $total_programas; ?></p>
                        <a href="programas.php" class="btn btn-secondary">Gestionar</a>
                    </div>

                    <div class="stat-card">
                        <h3>Colegios Registrados</h3>
                        <p class="stat-number"><?php echo $total_colegios; ?></p>
                        <a href="colegios.php" class="btn btn-secondary">Gestionar</a>
                    </div>
                </div>

                <div class="dashboard-section">
                    <h3>Programas Más Populares</h3>
                    <div class="popular-programs">
                        <?php if (count($programas_populares) > 0): ?>
                            <ul>
                                <?php foreach ($programas_populares as $programa): ?>
                                <li>
                                    <span class="program-name"><?php echo htmlspecialchars($programa['nombre']); ?></span>
                                    <span class="program-count"><?php echo $programa['selecciones']; ?> selecciones</span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No hay datos de programas seleccionados aún.</p>
                        <?php endif; ?>
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
</body>
</html>