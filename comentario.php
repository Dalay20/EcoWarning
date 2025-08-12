<?php
require 'db.php';
$db = conectarBD();

// ID de la denuncia que llega por URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener datos de la denuncia
$stmt = $db->prepare("SELECT * FROM denuncias WHERE id = ?");
$stmt->execute([$id]);
$denuncia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$denuncia) {
    echo "Denuncia no encontrada.";
    exit;
}

// Procesar nuevo comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comentario'])) {
    $comentario = trim($_POST['comentario']);
    $stmt = $db->prepare("INSERT INTO comentarios (id_denuncia, comentario) VALUES (?, ?)");
    $stmt->execute([$id, $comentario]);
}

// Obtener comentarios existentes
$stmt = $db->prepare("SELECT * FROM comentarios WHERE id_denuncia = ? ORDER BY fecha DESC");
$stmt->execute([$id]);
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comentarios - Denuncia #<?php echo $id; ?></title>
</head>
<body>
    <h1>Denuncia #<?php echo $id; ?> - <?php echo htmlspecialchars($denuncia['tipo']); ?></h1>
    <p><b>Ubicación:</b> <?php echo htmlspecialchars($denuncia['ubicacion']); ?></p>
    <p><b>Descripción:</b> <?php echo htmlspecialchars($denuncia['descripcion']); ?></p>
    <?php if ($denuncia['foto']): ?>
        <img src="<?php echo $denuncia['foto']; ?>" width="200"><br>
    <?php endif; ?>
    <hr>

    <h2>Comentarios</h2>
    <form method="POST">
        <textarea name="comentario" required placeholder="Escribe un comentario..."></textarea><br>
        <button type="submit">Agregar comentario</button>
    </form>
    <hr>

    <?php if ($comentarios): ?>
        <ul>
            <?php foreach ($comentarios as $c): ?>
                <li>
                    <?php echo htmlspecialchars($c['comentario']); ?> 
                    <br><small><?php echo $c['fecha']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay comentarios aún.</p>
    <?php endif; ?>

    <p><a href="index.php">← Volver al mapa</a></p>
</body>
</html>
