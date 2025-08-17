<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

$db = conectarBD();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // --- Obtener comentarios de una denuncia ---
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["ok" => false, "error" => "ID de denuncia inválido"]);
            exit;
        }

        // Buscar la denuncia
        $stmt = $db->prepare("SELECT * FROM denuncias WHERE id = ?");
        $stmt->execute([$id]);
        $denuncia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$denuncia) {
            http_response_code(404);
            echo json_encode(["ok" => false, "error" => "Denuncia no encontrada"]);
            exit;
        }

        // Obtener comentarios
        $stmt = $db->prepare("SELECT * FROM comentarios WHERE id_denuncia = ? ORDER BY fecha DESC");
        $stmt->execute([$id]);
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "ok" => true,
            "denuncia" => $denuncia,
            "comentarios" => $comentarios
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --- Insertar nuevo comentario ---
        $idDenuncia = $_POST['id_denuncia'] ?? null;
        $comentario = $_POST['comentario'] ?? null;

        if (!$idDenuncia || !$comentario) {
            http_response_code(400);
            echo json_encode(["ok" => false, "error" => "Faltan campos obligatorios"]);
            exit;
        }

        $stmt = $db->prepare("INSERT INTO comentarios (id_denuncia, comentario) VALUES (?, ?)");
        $stmt->execute([$idDenuncia, trim($comentario)]);

        echo json_encode([
            "ok" => true,
            "mensaje" => "Comentario agregado correctamente"
        ]);
        exit;
    }

    // Si llega otro método HTTP
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "Método no permitido"]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error en la base de datos",
        "detalle" => $e->getMessage()
    ]);
}
