<?php
require 'conexion.php';

// Obtener el ID de la Reserva desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
	die('ID de reserva no especificado.');
}

// Si el formulario se envía, actualizar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id_cliente = $_POST['id_cliente'];
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
	$precio = $_POST['precio'];
	$observaciones= $_POST['observaciones'];

	$stmt = $pdo->prepare("UPDATE reservas SET
    	id_cliente = :id_cliente,
    	fecha_inicio = :fecha_inicio,
    	fecha_fin = :fecha_fin,
    	precio = :precio,
    	observaciones = :observaciones
    	WHERE id = :id");
	$stmt->execute([
    	':id_cliente' => $id_cliente,
    	':fecha_inicio' => $fecha_inicio,
    	':fecha_fin' => $fecha_fin,
    	':precio' => $precio,
    	':observaciones' => $observaciones,
	':id' => $id,
	]);

	header('Location: todasLasReservas.php');
	exit;
}

// Obtener los datos de la reserva para rellenar el formulario
$stmt = $pdo->prepare("SELECT * FROM reservas WHERE id = :id");
$stmt->execute([':id' => $id]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
	die('Reserva no encontrada.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-warning">Editar Reserva</h1>
        <form class="mt-4" method="POST" action="editar_reserva.php?id=<?= $id ?>">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">ID Cliente</label>
                <input type="number" class="form-control" id="id_cliente" name="id_cliente" value="<?= htmlspecialchars($reserva['id_cliente']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($reserva['fecha_inicio']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($reserva['fecha_fin']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($reserva['precio']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones" value="<?= htmlspecialchars($reserva['observaciones']) ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                <a href="todasLasReservas.php" class="btn btn-secondary btn-lg">Volver al listado</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
