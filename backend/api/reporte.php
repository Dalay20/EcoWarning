<?php
require 'db.php';
$db = conectarBD();

// Contar denuncias por tipo
$stmt = $db->query("SELECT tipo, COUNT(*) as total FROM denuncias GROUP BY tipo");
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tipos = [];
$totales = [];

foreach ($datos as $fila) {
    $tipos[] = ucfirst($fila['tipo']);
    $totales[] = $fila['total'];
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
?>
