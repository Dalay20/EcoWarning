<?php
function conectarBD() {
    $db = new PDO('sqlite: ecowarning.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>