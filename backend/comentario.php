<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

$db = conectarBD();


function body_param($key){
    if (isset($POST[$key])) return $_POST[$key];

    static $json = null;
    if ($json === null) {
        $raw = file_get_contents('php://input');
        if ($raw) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $json = $decoded;
            } else {
                $json = [];
            }
        } else {
            $json = [];
        }
    }
    return $json[$key] ?? null;
}
try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["ok" => false, "error" => "ID de denuncia inválido"]);
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM denuncias WHERE id = ?");
        $stmt->execute([$id]);
        $denuncia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$denuncia) {
            http_response_code(404);
            echo json_encode(["ok" => false, "error" => "Denuncia no encontrada"]);
            exit;
        }

        $stmt = $db->prepare("
        SELECT id,id_denuncia,comentario,fecha
        FROM comentarios 
        WHERE id_denuncia = ? 
        ORDER BY fecha DESC
        ");
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
    $idDenuncia = $_POST['id_denuncia'] ?? null;
    $comentario = $_POST['comentario'] ?? null;

    if ($idDenuncia === null || $comentario === null) {
        $raw = file_get_contents('php://input');
        if ($raw) {
            $json = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                if ($idDenuncia === null) $idDenuncia = $json['id_denuncia'] ?? null;
                if ($comentario === null)  $comentario  = $json['comentario']  ?? null;
            }
        }
    }

    $idDenuncia = intval($idDenuncia);
    $comentario = is_string($comentario) ? trim($comentario) : '';

    if ($idDenuncia <= 0 || $comentario === '') {
        http_response_code(400);
        echo json_encode(["ok" => false, "error" => "Faltan campos obligatorios"]);
        exit;
    }

    $stmt = $db->prepare("
        INSERT INTO comentarios (id_denuncia, comentario)
        VALUES (?, ?)
    ");
    $stmt->execute([$idDenuncia, $comentario]);

    $newId = $db->lastInsertId();

    $stmt = $db->prepare("
        SELECT id, id_denuncia, comentario, fecha
        FROM comentarios
        WHERE id = ?
    ");
    $stmt->execute([$newId]);
    $nuevoComentario = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "ok" => true,
        "mensaje" => "Comentario agregado correctamente",
        "comentario" => $nuevoComentario
    ]);
    exit;
}


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
