<?php
require_once '../config/db.php';
require_once '../config/session.php';
verificarAutenticacion();

$error = '';
$success = '';

// Procesar formulario de agregar/editar programa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
    $imagen = trim(filter_var($_POST['imagen'], FILTER_SANITIZE_STRING));
    $activo = isset($_POST['activo']) ? 1 : 0;

    if (empty($nombre) || empty($descripcion)) {
        $error = 'Nombre y descripción son obligatorios';
    } else {
        try {
            if ($id > 0) {
                // Actualizar programa existente
                $stmt = $pdo->prepare("UPDATE programas SET nombre = ?, descripcion = ?, imagen = ?, activo = ? WHERE id = ?");
                $stmt->execute([$nombre, $descripcion, $imagen, $activo, $id]);
                $success = 'Programa actualizado correctamente';
            } else {
                // Insertar nuevo programa
                $stmt = $pdo->prepare("INSERT INTO programas (nombre, descripcion, imagen, activo) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nombre, $descripcion, $imagen, $activo]);
                $success = 'Programa agregado correctamente';
            }
        } catch (Exception $e) {
            error_log("Error al guardar programa: " . $e->getMessage());
            $error = 'Error al guardar el programa';
        }
    }
}

// Procesar eliminación de programa
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE programas SET activo = 0 WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Programa eliminado correctamente';
    } catch (Exception $e) {
        error_log("Error al eliminar programa: " . $e->getMessage());
        $error = 'Error al eliminar el programa';
    }
}

// Obtener programas
$programas = $pdo->query("SELECT * FROM programas ORDER BY activo DESC, nombre ASC")->fetchAll();

// Obtener programa para edición
$programa_editar = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM programas WHERE id = ?");
    $stmt->execute([$id]);
    $programa_editar = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Programas - Conexión Vocacional</title>
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
                    <li class="active"><a href="programas.php">Gestión de Programas</a></li>
                    <li><a href="colegios.php">Gestión de Colegios</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <h2>Gestión de Programas</h2>

                <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <!-- Formulario de agregar/editar programa -->
                <div class="admin-form">
                    <h3><?php echo $programa_editar ? 'Editar Programa' : 'Agregar Nuevo Programa'; ?></h3>
                    <form method="POST">
                        <?php if ($programa_editar): ?>
                        <input type="hidden" name="id" value="<?php echo $programa_editar['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="nombre">Nombre del Programa *</label>
                            <input type="text" id="nombre" name="nombre" required
                                   value="<?php echo $programa_editar ? htmlspecialchars($programa_editar['nombre']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción *</label>
                            <textarea id="descripcion" name="descripcion" required rows="4"><?php 
                                echo $programa_editar ? htmlspecialchars($programa_editar['descripcion']) : ''; 
                            ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="imagen">Nombre de la Imagen</label>
                            <input type="text" id="imagen" name="imagen"
                                   value="<?php echo $programa_editar ? htmlspecialchars($programa_editar['imagen']) : ''; ?>"
                                   placeholder="Ej: programacion.jpg">
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="activo" value="1" 
                                    <?php echo (!$programa_editar || $programa_editar['activo']) ? 'checked' : ''; ?>>
                                Programa activo
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $programa_editar ? 'Actualizar' : 'Agregar'; ?> Programa
                            </button>
                            <?php if ($programa_editar): ?>
                            <a href="programas.php" class="btn btn-secondary">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Lista de programas -->
                <div class="table-container">
                    <h3>Programas Registrados</h3>
                    
                    <?php if (count($programas) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($programas as $programa): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($programa['nombre']); ?></td>
                                <td><?php echo htmlspecialchars(substr($programa['descripcion'], 0, 100) . '...'); ?></td>
                                <td><?php echo htmlspecialchars($programa['imagen']); ?></td>
                                <td>
                                    <span class="status <?php echo $programa['activo'] ? 'active' : 'inactive'; ?>">
                                        <?php echo $programa['activo'] ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $programa['id']; ?>" class="btn btn-small">Editar</a>
                                    <?php if ($programa['activo']): ?>
                                    <a href="?delete=<?php echo $programa['id']; ?>" class="btn btn-small btn-danger" 
                                       onclick="return confirm('¿Está seguro de eliminar este programa?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>No hay programas registrados.</p>
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