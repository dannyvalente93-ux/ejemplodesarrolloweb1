<?php
require 'config.php';
verificarSesion();

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $ciudad = trim($_POST['ciudad']);
    $id_usuario = $_SESSION['usuario_id'];

    if (empty($nombre) || empty($telefono) || empty($correo) || empty($ciudad)) {
        $error = "⚠️ Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id_usuario, $nombre, $telefono, $correo, $ciudad);
        
        if ($stmt->execute()) {
            header("Location: panel.php");
            exit();
        } else {
            $error = "❌ Error al guardar el contacto.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Contacto</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; font-size: 16px; }
        button { background: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; font-size: 16px; cursor: pointer; }
        .error { color: red; background: #ffebee; padding: 10px; border-radius: 4px; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <h2>➕ Nuevo Contacto</h2>
    <p><a href="panel.php">← Volver al panel</a></p>
    
    <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Teléfono:</label>
            <input type="text" name="telefono" required>
        </div>
        <div class="form-group">
            <label>Correo:</label>
            <input type="email" name="correo" required>
        </div>
        <div class="form-group">
            <label>Ciudad:</label>
            <input type="text" name="ciudad" required>
        </div>
        <button type="submit">Guardar Contacto</button>
    </form>
</body>
</html>