<?php
session_start();

// Configuración de seguridad para sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Usar solo si está en HTTPS
ini_set('session.use_strict_mode', 1);

// Regenerar ID de sesión cada 5 minutos
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Verificar si el usuario está autenticado (para páginas de admin)
function verificarAutenticacion() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ../login.php');
        exit;
    }
}

// Verificar si el usuario NO está autenticado (para páginas públicas)
function verificarNoAutenticado() {
    if (isset($_SESSION['admin_id'])) {
        header('Location: admin/index.php');
        exit;
    }
}
?>