<?php
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

?>
