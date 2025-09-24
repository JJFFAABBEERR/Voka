<?php
// includes/header.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexión Vocacional - SENA</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Barra superior gov.co -->
    <div class="gov-bar">
        <div class="container">
            <div class="gov-links">
                <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Inicio</a>
                
            </div>
            <div class="auth-links">
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="admin/index.php" class="btn-auth">Panel Admin</a>
                    <a href="logout.php" class="btn-auth">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn-auth">Ingresar</a>
                    <a href="registro.php" class="btn-auth btn-register">Registrarme</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Header principal -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <img src="assets/img/logo_sena_verde.png" alt="Logo SENA" class="logo">
                    <div class="title-section">
                        <h1>Conexión Vocacional</h1>
                        <p>Servicio Nacional de Aprendizaje - SENA</p>
                    </div>
                </div>
                <div class="header-actions">
                    <?php if ($current_page != 'registro.php' && $current_page != 'login.php'): ?>
                        <a href="registro.php" class="btn btn-primary">Registrarse en programas</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>