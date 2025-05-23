<?php
require 'conexion.php';

// Obtener el ID de la reserva desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID de reserva no especificado.');
}

// Eliminar la reserva de la base de datos
$stmt = $pdo->prepare("DELETE FROM reservas WHERE id = :id");
$stmt->execute([':id' => $id]);

// Redirigir al listado de reservas
header('Location:todasLasReservas.php');
exit;
?>
