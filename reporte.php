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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de denuncias</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Reporte de denuncias por tipo</h1>
    <canvas id="grafico" width="50" height="50"></canvas>
    <button type="button" onclick="window.location.href='index.php'"> Volver al mapa </button>

    <script>
    var ctx = document.getElementById('grafico').getContext('2d');
    var grafico = new Chart(ctx, {
        type: 'bar', // También puede ser 'pie' o 'doughnut'
        data: {
            labels: <?php echo json_encode($tipos); ?>,
            datasets: [{
                label: 'Cantidad de denuncias',
                data: <?php echo json_encode($totales); ?>,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                borderColor: '#333',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    </script>
</body>
</html>
