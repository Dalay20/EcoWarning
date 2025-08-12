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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mapa de denuncias</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        #map { height: 500px; margin-top: 20px; }
        form { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>EcoWarning! - Denuncias</h1>
    <a href="formulario.php">Registrar nueva denuncia</a>

    <!-- Formulario de filtros -->
    <form method="GET">
        <label>Tipo de incidente:</label>
        <select name="tipo">
            <option value="">Todos</option>
            <option value="quema" <?php if($filtroTipo=='quema') echo 'selected'; ?>>Quema</option>
            <option value="contaminacion" <?php if($filtroTipo=='contaminacion') echo 'selected'; ?>>Contaminación</option>
            <option value="mineria" <?php if($filtroTipo=='mineria') echo 'selected'; ?>>Minería ilegal</option>
        </select>

        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?php echo htmlspecialchars($filtroFecha); ?>">

        <label>Gravedad:</label>
        <select name="gravedad">
            <option value="">Todas</option>
            <option value="baja" <?php if(isset($_GET['gravedad']) && $_GET['gravedad']=='baja') echo 'selected'; ?>>Baja</option>
            <option value="media" <?php if(isset($_GET['gravedad']) && $_GET['gravedad']=='media') echo 'selected'; ?>>Media</option>
            <option value="alta" <?php if(isset($_GET['gravedad']) && $_GET['gravedad']=='alta') echo 'selected'; ?>>Alta</option>
        </select>

        <button type="submit">Filtrar</button>
        <a href="index.php">Quitar filtros</a>
    </form>

    <!-- Botón para ver estadísticas -->
    <p>
        <a href="reporte.php">Estadísticas</a>
    </p>

    <div id="map"></div>

    <!-- Lista de denuncias -->
    <h2>Listado de denuncias</h2>
    <?php if ($denuncias): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Foto</th>
                <th>Acciones</th>
                <th>Gravedad</th>
            </tr>
            <?php foreach ($denuncias as $d): ?>
            <tr>
                <td><?php echo htmlspecialchars($d['tipo']); ?></td>
                <td><?php echo htmlspecialchars($d['ubicacion']); ?></td>
                <td><?php echo htmlspecialchars($d['descripcion']); ?></td>
                <td><?php echo $d['fecha']; ?></td>
                <td>
                    <?php if ($d['foto']): ?>
                        <img src="<?php echo $d['foto']; ?>" width="80">
                    <?php else: ?>
                        Sin foto
                    <?php endif; ?>
                </td>
                <td>
                    <a href="comentario.php?id=<?php echo $d['id']; ?>">Ver comentarios</a>
                </td>
                <td><?php echo ucfirst($d['gravedad']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay denuncias para mostrar.</p>
    <?php endif; ?>



    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    var map = L.map('map').setView([-1.8312, -78.1834], 6); // Ecuador

    // Capa base
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(map);

    var denuncias = <?php echo json_encode($denuncias); ?>;

    denuncias.forEach(function(d) {
        if (d.ubicacion) {
            var coords = d.ubicacion.split(",");
            var marker = L.marker([parseFloat(coords[0]), parseFloat(coords[1])]).addTo(map);
            var popup = "<b>" + d.tipo + "</b> (" + d.gravedad + ")<br>" + d.descripcion;
            if (d.foto) {
                popup += "<br><img src='" + d.foto + "' width='150'>";
            }
            popup += "<br><a href='comentario.php?id=" + d.id + "'>Ver comentarios</a>";
            marker.bindPopup(popup);
        }
    });
    </script>
</body>
</html>
