<?php
require 'conexion.php';
// Búsqueda con PDO y protección contra inyecciones
$busqueda = $_GET['buscar'] ?? '';
if ($busqueda) {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE nombre LIKE :busqueda OR apellidos LIKE :busqueda");
    $stmt->execute(['busqueda' => "%$busqueda%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM clientes");
}
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Listado de Clientes</h1>
        <div class="d-flex justify-content-between my-4">
            <a href="crear_cliente.php" class="btn btn-success">➕ Añadir nuevo cliente</a>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar cliente" value="<?= htmlspecialchars($busqueda) ?>">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Fecha Nac.</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente['id'] ?></td>
                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                    <td><?= htmlspecialchars($cliente['apellidos']) ?></td>
                    <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                    <td><?= htmlspecialchars($cliente['ciudad']) ?></td>
                    <td><?= $cliente['fecha_nacimiento'] ?></td>
                    <td><?= $cliente['telefono'] ?></td>
                    <td><?= $cliente['email'] ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <a href="eliminar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">🗑️ Eliminar</a>
			<a href="reservas.php?id_cliente=<?= $cliente['id'] ?>" class="btn btn-info btn-sm">📅 Ver Reservas</a> 
 			 <a href="crear_reserva.php?id_cliente=<?= $cliente['id'] ?>" class="btn btn-info btn-sm">➕ Crear Reserva</a>
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
