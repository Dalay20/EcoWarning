<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $ubicacion = $_POST['ubicacion'];
    $descripcion = $_POST['descripcion'];
    $gravedad = $_POST['gravedad'];

    // Manejo de la foto
    $fotoRuta = null;
    if (!empty($_FILES['foto']['name'])) {
        $nombreFoto = time() . "_" . basename($_FILES['foto']['name']);
        $rutaDestino = "uploads/" . $nombreFoto;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
            $fotoRuta = $rutaDestino;
        }
    }

    try {
        $db = conectarBD();
        $stmt = $db->prepare("INSERT INTO denuncias (tipo, ubicacion, descripcion, foto, gravedad) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tipo, $ubicacion, $descripcion, $fotoRuta, $gravedad]);

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Método no permitido";
}
?>
