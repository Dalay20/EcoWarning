<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

$db = conectarBD();

try {
    // Contar denuncias por tipo
    $stmt = $db->query("SELECT tipo, COUNT(*) as total FROM denuncias GROUP BY tipo");
    $datosTipo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tipos = [];
    $totalesTipo = [];
    foreach ($datosTipo as $fila) {
        $tipos[] = ucfirst($fila['tipo']);
        $totalesTipo[] = $fila['total'];
    }

    // Contar denuncias por gravedad
    $stmt2 = $db->query("SELECT gravedad, COUNT(*) as total FROM denuncias GROUP BY gravedad");
    $datosGravedad = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $niveles = [];
    $totalesGravedad = [];
    foreach ($datosGravedad as $fila) {
        $niveles[] = ucfirst($fila['gravedad']);
        $totalesGravedad[] = $fila['total'];
    }

    // Respuesta en JSON
    echo json_encode([
        "ok" => true,
        "por_tipo" => [
            "labels" => $tipos,
            "values" => $totalesTipo
        ],
        "por_gravedad" => [
            "labels" => $niveles,
            "values" => $totalesGravedad
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error al generar reporte",
        "detalle" => $e->getMessage()
    ]);
}

