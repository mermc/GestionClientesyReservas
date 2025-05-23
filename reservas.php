<?php
require 'conexion.php';

$id_cliente = $_GET['id_cliente'] ?? null;

if (!$id_cliente) {
    echo "ID de cliente no especificado.";
    exit;
}

// datos del cliente
$stmt = $pdo->prepare("SELECT nombre, apellidos FROM clientes WHERE id = :id_cliente");
$stmt->execute([':id_cliente' => $id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    die(" Error: Cliente no encontrado.");
}
// Obtener reservas del cliente
$stmt = $pdo->prepare("SELECT * FROM reservas WHERE id_cliente = :id_cliente");
$stmt->execute([':id_cliente' => $id_cliente]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC)
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellidos']) ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Reservas de <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellidos']) ?></h1>
        <div class="text-end mb-3">
            <a href="crear_reserva.php?id_cliente=<?= $id_cliente ?>" class="btn btn-success">➕ Añadir Reserva</a>
            <a href="clientes.php" class="btn btn-secondary">Volver a Clientes</a>
        </div>
        <?php if (count($reservas) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID Reserva</th>
                    	<th>ID Cliente</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Precio</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= $reserva['id'] ?></td>
                    	    <td><?= $reserva['id_cliente'] ?></td>
                            <td><?= $reserva['fecha_inicio'] ?></td>
                            <td><?= $reserva['fecha_fin'] ?></td>
                            <td><?= $reserva['precio'] ?></td>
                            <td><?= htmlspecialchars($reserva['observaciones']) ?></td>
                            <td>
                                <a href="editar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                                <a href="eliminar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta reserva?');">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay reservas para este cliente.</div>
        <?php endif; ?>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

