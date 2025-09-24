<?php
// Script de instalación - EJECUTAR UNA SOLA VEZ Y LUEGO ELIMINAR
if (file_exists('config/db.php')) {
    die('El sistema ya está instalado. Elimine este archivo por seguridad.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $dbname = $_POST['dbname'] ?? 'conexion_vocacional';
    $username = $_POST['username'] ?? 'root';
    $password = $_POST['password'] ?? '';
    
    try {
        // Crear archivo de configuración
        $configContent = "<?php
\$host = '$host';
\$dbname = '$dbname';
\$username = '$username';
\$password = '$password';

try {
    \$pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname;charset=utf8mb4\", \$username, \$password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException \$e) {
    error_log(\"Error de conexión a BD: \" . \$e->getMessage());
    die(\"Error del sistema. Por favor intente más tarde.\");
}
?>";
        
        file_put_contents('config/db.php', $configContent);
        
        // Conectar y ejecutar SQL
        require_once 'config/db.php';
        $sql = file_get_contents('sql/conexion_vocacional.sql');
        $pdo->exec($sql);
        
        $success = 'Instalación completada correctamente. Elimine este archivo por seguridad.';
    } catch (Exception $e) {
        $error = 'Error durante la instalación: ' . $e->getMessage();
        // Eliminar archivo de configuración si hubo error
        if (file_exists('config/db.php')) {
            unlink('config/db.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Instalación - Conexión Vocacional</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; }
        button { background: #39A900; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Instalación - Conexión Vocacional SENA</h1>
    
    <?php if (isset($success)): ?>
    <div class="alert success"><?php echo $success; ?></div>
    <?php elseif (isset($error)): ?>
    <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Host de la base de datos:</label>
            <input type="text" name="host" value="localhost" required>
        </div>
        
        <div class="form-group">
            <label>Nombre de la base de datos:</label>
            <input type="text" name="dbname" value="conexion_vocacional" required>
        </div>
        
        <div class="form-group">
            <label>Usuario de la base de datos:</label>
            <input type="text" name="username" value="root" required>
        </div>
        
        <div class="form-group">
            <label>Contraseña de la base de datos:</label>
            <input type="password" name="password">
        </div>
        
        <button type="submit">Instalar Sistema</button>
    </form>
    
    <p><strong>Nota:</strong> Después de la instalación exitosa, elimine este archivo por seguridad.</p>
</body>
</html>