<?php
require 'conexion.php';

// Obtener el ID del cliente desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID de cliente no especificado.');
}

// Si el formulario se envía, actualizar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE clientes SET 
        nombre = :nombre, 
        apellidos = :apellidos, 
        direccion = :direccion, 
        ciudad = :ciudad, 
        fecha_nacimiento = :fecha_nacimiento, 
        telefono = :telefono, 
        email = :email 
        WHERE id = :id");
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':direccion' => $direccion,
        ':ciudad' => $ciudad,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':telefono' => $telefono,
        ':email' => $email,
        ':id' => $id
    ]);

    header('Location: clientes.php');
    exit;
}

// Obtener los datos del cliente para rellenar el formulario
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    die('Cliente no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-warning">Editar Cliente</h1>
        <form class="mt-4" method="POST" action="editar_cliente.php?id=<?= $id ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($cliente['apellidos']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($cliente['direccion']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= htmlspecialchars($cliente['ciudad']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $cliente['fecha_nacimiento'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                <a href="clientes.php" class="btn btn-secondary btn-lg">Volver al listado</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
