<?php
require_once '../config/db.php';
require_once '../config/session.php';
verificarAutenticacion();

$error = '';
$success = '';

// Procesar formulario de agregar/editar colegio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $direccion = trim(filter_var($_POST['direccion'], FILTER_SANITIZE_STRING));
    $ciudad = trim(filter_var($_POST['ciudad'], FILTER_SANITIZE_STRING));
    $activo = isset($_POST['activo']) ? 1 : 0;

    if (empty($nombre) || empty($ciudad)) {
        $error = 'Nombre y ciudad son obligatorios';
    } else {
        try {
            if ($id > 0) {
                // Actualizar colegio existente
                $stmt = $pdo->prepare("UPDATE colegios SET nombre = ?, direccion = ?, ciudad = ?, activo = ? WHERE id = ?");
                $stmt->execute([$nombre, $direccion, $ciudad, $activo, $id]);
                $success = 'Colegio actualizado correctamente';
            } else {
                // Insertar nuevo colegio
                $stmt = $pdo->prepare("INSERT INTO colegios (nombre, direccion, ciudad, activo) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nombre, $direccion, $ciudad, $activo]);
                $success = 'Colegio agregado correctamente';
            }
        } catch (Exception $e) {
            error_log("Error al guardar colegio: " . $e->getMessage());
            $error = 'Error al guardar el colegio';
        }
    }
}

// Procesar eliminación de colegio
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        // Verificar si hay estudiantes asociados
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM estudiantes WHERE colegio_id = ?");
        $stmt->execute([$id]);
        $total_estudiantes = $stmt->fetch()['total'];

        if ($total_estudiantes > 0) {
            $error = 'No se puede eliminar el colegio porque tiene estudiantes asociados';
        } else {
            $stmt = $pdo->prepare("UPDATE colegios SET activo = 0 WHERE id = ?");
            $stmt->execute([$id]);
            $success = 'Colegio eliminado correctamente';
        }
    } catch (Exception $e) {
        error_log("Error al eliminar colegio: " . $e->getMessage());
        $error = 'Error al eliminar el colegio';
    }
}

// Obtener colegios
$colegios = $pdo->query("SELECT c.*, 
                         (SELECT COUNT(*) FROM estudiantes e WHERE e.colegio_id = c.id) as total_estudiantes
                         FROM colegios c 
                         ORDER BY c.activo DESC, c.nombre ASC")->fetchAll();

// Obtener colegio para edición
$colegio_editar = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM colegios WHERE id = ?");
    $stmt->execute([$id]);
    $colegio_editar = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Colegios - Conexión Vocacional</title>
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
                    <li class="active"><a href="colegios.php">Gestión de Colegios</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <h2>Gestión de Colegios</h2>

                <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <!-- Formulario de agregar/editar colegio -->
                <div class="admin-form">
                    <h3><?php echo $colegio_editar ? 'Editar Colegio' : 'Agregar Nuevo Colegio'; ?></h3>
                    <form method="POST">
                        <?php if ($colegio_editar): ?>
                        <input type="hidden" name="id" value="<?php echo $colegio_editar['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="nombre">Nombre del Colegio *</label>
                            <input type="text" id="nombre" name="nombre" required
                                   value="<?php echo $colegio_editar ? htmlspecialchars($colegio_editar['nombre']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <textarea id="direccion" name="direccion" rows="3"><?php 
                                echo $colegio_editar ? htmlspecialchars($colegio_editar['direccion']) : ''; 
                            ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="ciudad">Ciudad *</label>
                            <input type="text" id="ciudad" name="ciudad" required
                                   value="<?php echo $colegio_editar ? htmlspecialchars($colegio_editar['ciudad']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="activo" value="1" 
                                    <?php echo (!$colegio_editar || $colegio_editar['activo']) ? 'checked' : ''; ?>>
                                Colegio activo
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $colegio_editar ? 'Actualizar' : 'Agregar'; ?> Colegio
                            </button>
                            <?php if ($colegio_editar): ?>
                            <a href="colegios.php" class="btn btn-secondary">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Lista de colegios -->
                <div class="table-container">
                    <h3>Colegios Registrados</h3>
                    
                    <?php if (count($colegios) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Estudiantes</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colegios as $colegio): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($colegio['nombre']); ?></td>
                                <td><?php echo htmlspecialchars(substr($colegio['direccion'], 0, 50) . '...'); ?></td>
                                <td><?php echo htmlspecialchars($colegio['ciudad']); ?></td>
                                <td><?php echo $colegio['total_estudiantes']; ?></td>
                                <td>
                                    <span class="status <?php echo $colegio['activo'] ? 'active' : 'inactive'; ?>">
                                        <?php echo $colegio['activo'] ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $colegio['id']; ?>" class="btn btn-small">Editar</a>
                                    <?php if ($colegio['activo'] && $colegio['total_estudiantes'] == 0): ?>
                                    <a href="?delete=<?php echo $colegio['id']; ?>" class="btn btn-small btn-danger" 
                                       onclick="return confirm('¿Está seguro de eliminar este colegio?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>No hay colegios registrados.</p>
                    <?php endif; ?>
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