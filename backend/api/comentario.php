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