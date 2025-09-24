<?php
require_once '../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM programas WHERE id = ? AND activo = TRUE");
    $stmt->execute([$id]);
    $programa = $stmt->fetch();

    if ($programa) {
        echo json_encode([
            'success' => true, 
            'programa' => [
                'id' => $programa['id'],
                'nombre' => $programa['nombre'],
                'descripcion' => $programa['descripcion'],
                'imagen' => $programa['imagen']
            ]
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Programa no encontrado']);
    }
} catch (Exception $e) {
    error_log("Error al obtener programa: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>