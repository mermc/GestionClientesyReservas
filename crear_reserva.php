<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Recoger datos del formulario
	$id_cliente = $_POST['id_cliente'];
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
	$precio = $_POST['precio'];
	$observaciones= $_POST['observaciones'];

    // Validar que la fecha_fin no sea anterior a la fecha_inicio
    if ($fecha_fin < $fecha_inicio) {
        echo "<div class='alert alert-danger text-center'> Error: La fecha de fin no puede ser anterior a la fecha de inicio.</div>";
    } else {

	// Insertar en la base de datos
	$stmt = $pdo->prepare("INSERT INTO reservas (id_cliente, fecha_inicio, fecha_fin, precio, observaciones)
                       	VALUES (:id_cliente, :fecha_inicio, :fecha_fin, :precio, :observaciones)");
	$stmt->execute([
    	':id_cliente' => $id_cliente,
    	':fecha_inicio' => $fecha_inicio,
    	':fecha_fin' => $fecha_fin,
    	':precio' => $precio,
    	':observaciones' => $observaciones,
	]);

	// Redirigir al listado de clientes
	header('Location: todasLasReservas.php');
	exit;
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Reserva</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Añadir Reserva</h1>
        <form class="mt-4" method="POST" action="crear_reserva.php">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">ID Cliente</label>
                <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">Añadir Reserva</button>
                <a href="todasLasReservas.php" class="btn btn-secondary btn-lg">Volver al listado de Reservas</a>
<a href="clientes.php" class="btn btn-secondary btn-lg">Volver al listado de Clientes</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
