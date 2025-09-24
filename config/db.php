<?php
// Configuración de base de datos para producción
$host = 'localhost';
$dbname = 'conexion_vocacional';
$username = 'root'; // Cambiar en producción
$password = ''; // Cambiar en producción

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log("Error de conexión a BD: " . $e->getMessage());
    die("Error del sistema. Por favor intente más tarde.");
}
?>