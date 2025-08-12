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

$stmt2 = $db->query("SELECT gravedad, COUNT(*) as total FROM denuncias GROUP BY gravedad");
$datosGravedad = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$niveles = [];
$totalesGravedad = [];

foreach ($datosGravedad as $fila) {
    $niveles[] = ucfirst($fila['gravedad']);
    $totalesGravedad[] = $fila['total'];
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

    <h2>Reporte por nivel de gravedad</h2>
    <canvas id="graficoGravedad" width="400" height="200"></canvas>

    <script>
    var ctx2 = document.getElementById('graficoGravedad').getContext('2d');
    var grafico2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($niveles); ?>,
            datasets: [{
                label: 'Cantidad de denuncias',
                data: <?php echo json_encode($totalesGravedad); ?>,
                backgroundColor: ['#4caf50', '#ff9800', '#f44336']
            }]
        },
        options: { responsive: true }
    });
    </script>

</body>
</html>
