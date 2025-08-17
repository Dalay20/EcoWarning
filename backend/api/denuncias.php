<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Solo para desarrollo
require '../db.php';

$db = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filtroTipo = $_GET['tipo'] ?? null;
    $filtroGravedad = $_GET['gravedad'] ?? null;
    $filtroFecha = $_GET['fecha'] ?? null;

    $query = "SELECT * FROM denuncias WHERE 1=1";
    $params = [];

    if ($filtroTipo) {
        $query .= " AND tipo = ?";
        $params[] = $filtroTipo;
    }
    if ($filtroGravedad) {
        $query .= " AND gravedad = ?";
        $params[] = $filtroGravedad;
    }
    if ($filtroFecha) {
        $query .= " AND DATE(fecha) = ?";
        $params[] = $filtroFecha;
    }

    $query .= " ORDER BY fecha DESC";

    $stmt = $db->prepare($query);
    $stmt->execute($params);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// POST: Crear nueva denuncia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validación básica
    if (empty($data['tipo']) || empty($data['ubicacion']) || empty($data['descripcion']) || empty($data['gravedad'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO denuncias (tipo, ubicacion, descripcion, fecha, foto, gravedad) VALUES (?, ?, ?, NOW(), ?, ?)");
    $stmt->execute([
        $data['tipo'],
        $data['ubicacion'],
        $data['descripcion'],
        $data['foto'] ?? null,
        $data['gravedad']
    ]);

    echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
    exit;
}

http_response_code(405); // Método no permitido
?>