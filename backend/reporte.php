<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

try {
    $db = conectarBD();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ÚLTIMOS 7 DÍAS (incluye hoy)
    $sqlTipo = "
        SELECT COALESCE(tipo,'Sin tipo') AS etiqueta, COUNT(*) AS total
        FROM denuncias
        WHERE datetime(fecha) >= datetime('now','-7 days')
        GROUP BY etiqueta
        ORDER BY total DESC
    ";
    $rowsTipo = $db->query($sqlTipo)->fetchAll(PDO::FETCH_ASSOC);

    $labelsTipo = [];
    $valuesTipo = [];
    foreach ($rowsTipo as $r) {
        $labelsTipo[] = ucfirst((string)$r['etiqueta']);
        $valuesTipo[] = (int)$r['total'];
    }

    $sqlGrav = "
        SELECT COALESCE(gravedad,'Sin gravedad') AS etiqueta, COUNT(*) AS total
        FROM denuncias
        WHERE datetime(fecha) >= datetime('now','-7 days')
        GROUP BY etiqueta
        ORDER BY total DESC
    ";
    $rowsGrav = $db->query($sqlGrav)->fetchAll(PDO::FETCH_ASSOC);

    $labelsGrav = [];
    $valuesGrav = [];
    foreach ($rowsGrav as $r) {
        $labelsGrav[] = ucfirst((string)$r['etiqueta']);
        $valuesGrav[] = (int)$r['total'];
    }

    echo json_encode([
        "ok" => true,
        "vacio" => (count($valuesTipo) === 0 && count($valuesGrav) === 0),
        "por_tipo" => ["labels" => $labelsTipo, "values" => $valuesTipo],
        "por_gravedad" => ["labels" => $labelsGrav, "values" => $valuesGrav]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error al generar reporte",
        "detalle" => $e->getMessage()
    ]);
}
