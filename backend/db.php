<?php
function conectarBD() {
    try {
        $db = new PDO('sqlite:' . __DIR__ . '/database.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        // Devolver error en formato JSON en lugar de morir con die()
        http_response_code(500);
        echo json_encode([
            "error" => "Error al conectar con la base de datos",
            "detalle" => $e->getMessage()
        ]);
        exit;
    }
}
?>
