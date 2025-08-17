<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    echo json_encode(["ok" => false, "error" => "Método no permitido"]);
    exit;
}

$tipo = $_POST['tipo'] ?? null;
$ubicacion = $_POST['ubicacion'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$gravedad = $_POST['gravedad'] ?? null;

// Validaciones básicas
if (!$tipo || !$ubicacion || !$descripcion || !$gravedad) {
    http_response_code(400);
    echo json_encode(["ok" => false, "error" => "Faltan campos obligatorios"]);
    exit;
}

// Manejo de la foto
$fotoRuta = null;
if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
    $uploadsDir = __DIR__ . "/uploads/";
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true); // crea la carpeta si no existe
    }

    $nombreFoto = time() . "_" . basename($_FILES['foto']['name']);
    $rutaDestino = $uploadsDir . $nombreFoto;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
        // Guardar ruta relativa (para evitar errores de mixed content en HTTPS)
        $fotoRuta = "/uploads/" . $nombreFoto;
    }
}


try {
    $db = conectarBD();
    $stmt = $db->prepare("INSERT INTO denuncias (tipo, ubicacion, descripcion, foto, gravedad) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$tipo, $ubicacion, $descripcion, $fotoRuta, $gravedad]);

    echo json_encode([
        "ok" => true,
        "mensaje" => "Denuncia registrada correctamente",
        "id" => $db->lastInsertId()
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error al guardar denuncia",
        "detalle" => $e->getMessage()
    ]);
}

