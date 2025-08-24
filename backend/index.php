<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

$db = conectarBD();

// Capturar filtros desde GET
$filtroTipo = isset($_GET['tipo']) && $_GET['tipo'] != '' ? $_GET['tipo'] : null;
$filtroFecha = isset($_GET['fecha']) && $_GET['fecha'] != '' ? $_GET['fecha'] : null;
$filtroGravedad = isset($_GET['gravedad']) && $_GET['gravedad'] != '' ? $_GET['gravedad'] : null;

$query = "SELECT * FROM denuncias WHERE 1=1";
$params = [];

if ($filtroTipo) {
    $query .= " AND tipo = ?";
    $params[] = $filtroTipo;
}

if ($filtroFecha) {
    $query .= " AND date(fecha) = ?";
    $params[] = $filtroFecha;
}

if ($filtroGravedad) {
    $query .= " AND gravedad = ?";
    $params[] = $filtroGravedad;
}

$query .= " ORDER BY fecha DESC";

try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $denuncias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Resumen general
    $totalDenuncias = count($denuncias);
    $totalAlta = 0;
    $totalMedia = 0;
    $totalBaja = 0;

    foreach ($denuncias as $d) {
        if ($d['gravedad'] == 'alta') {
            $totalAlta++;
        } elseif ($d['gravedad'] == 'media') {
            $totalMedia++;
        } elseif ($d['gravedad'] == 'baja') {
            $totalBaja++;
        }
    }

    echo json_encode([
        "ok" => true,
        "total" => $totalDenuncias,
        "resumen" => [
            "alta" => $totalAlta,
            "media" => $totalMedia,
            "baja" => $totalBaja
        ],
        "denuncias" => $denuncias
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error al consultar denuncias",
        "detalle" => $e->getMessage()
    ]);
}
?>


