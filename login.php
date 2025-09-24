<?php
require_once 'config/db.php';
//require_once 'config/session.php';

// Si ya está autenticado, redirigir al panel
if (isset($_SESSION['admin_id'])) {
    header('Location: admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $error = 'Por favor ingrese usuario y contraseña';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = ? AND activo = TRUE");
        $stmt->execute([$usuario]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_usuario'] = $admin['usuario'];
            $_SESSION['admin_nombre'] = $admin['nombre_completo'];
            $_SESSION['last_regeneration'] = time();

            header('Location: admin/index.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - Conexión Vocacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="assets/img/logo_sena_verde.png" alt="Logo SENA" class="logo">
            <h1>Acceso Administrador</h1>
            <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
        </div>
    </header>

    <main>
        <section class="login">
            <div class="container">
                <h2>Iniciar Sesión</h2>

                <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" class="form-login">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" required 
                               value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> SENA - Conexión Vocacional. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>