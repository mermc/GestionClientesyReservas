<?php
$host = 'localhost';
$db = 'gestion_clientes';
$user = 'gestioncliente';
$pass = '12341234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    die(" Error en la conexión: " . $e->getMessage());
}
?>
