<?php
require 'conexion.php';

// Obtener el ID del cliente desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID de cliente no especificado.');
}

// Eliminar el cliente de la base de datos
$stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
$stmt->execute([':id' => $id]);

// Redirigir al listado de clientes
header('Location:clientes.php');
exit;
?>
