<?php
function conectarBD() {
    $db = new PDO('sqlite:' . __DIR__ . '/ecowarning.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>