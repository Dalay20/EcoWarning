<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrar denuncia</title>
</head>
<body>
    <h1>Nueva Denuncia</h1>
    <form action="guardar.php" method="POST" enctype="multipart/form-data">
        <label>Tipo de incidente:</label>
        <select name="tipo" required>
            <option value="quema">Quema</option>
            <option value="contaminacion">Contaminación</option>
            <option value="mineria">Minería ilegal</option>
        </select>
        <br>

        <label>Ubicación (lat,long):</label>
        <input type="text" name="ubicacion" required>
        <br>

        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>
        <br>

        <label>Foto:</label>
        <input type="file" name="foto">
        <br>

        <button type="submit">Enviar denuncia</button>
        <button type="button" onclick="window.location.href='index.php'"> Cancelar y volver al mapa </button>
    </form>
</body>
</html>
