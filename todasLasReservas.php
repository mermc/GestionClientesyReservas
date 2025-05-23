<?php
require 'conexion.php';

// Búsqueda  PDO
$busqueda = $_GET['buscar'] ?? '';
if ($busqueda) {
    $stmt = $pdo->prepare("SELECT * FROM reservas WHERE id_cliente LIKE :busqueda OR fecha_inicio LIKE :busqueda OR fecha_fin LIKE :busqueda");
    $stmt->execute(['busqueda' => "%$busqueda%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM reservas");
}
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reservas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Listado de Reservas</h1>
        <form class="d-flex justify-content-between my-4" method="get" action="todasLasReservas.php">
            <input class="form-control w-75" type="text" name="buscar" placeholder="Buscar reserva..." value="<?= htmlspecialchars($busqueda) ?>">
            <button class="btn btn-outline-primary ms-2" type="submit">🔍 Buscar</button>
        </form>
        <div class="mb-3 text-end">
            <a href="crear_reserva.php" class="btn btn-success">➕ Añadir nueva reserva</a>
        </div>
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
<a href="index.php" class="btn btn-secondary">Volver al menú principal</a>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
