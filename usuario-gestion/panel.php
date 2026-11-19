<?php
require 'config.php';
verificarSesion(); // Solo usuarios autenticados pueden entrar

// Obtener los contactos del usuario
$stmt = $conexion->prepare("SELECT * FROM contactos WHERE id_usuario = ? ORDER BY nombre");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-nuevo { background: #28a745; color: white; }
        .btn-editar { background: #ffc107; color: #000; }
        .btn-eliminar { background: #dc3545; color: white; }
        .btn-salir { background: #6c757d; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .sin-contactos { color: #666; text-align: center; padding: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2>👋 Bienvenido, <?= $_SESSION['usuario_nombre'] ?></h2>
            <p>Correo: <?= $_SESSION['correo'] ?></p>
        </div>
        <a href="logout.php" class="btn btn-salir">Cerrar sesión</a>
    </div>

    <h3>📒 Mis Contactos</h3>
    <p><a href="contacto_registrar.php" class="btn btn-nuevo">➕ Registrar nuevo contacto</a></p>

    <?php if ($resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Ciudad</th>
                <th>Acciones</th>
            </tr>
            <?php while ($contacto = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $contacto['nombre'] ?></td>
                <td><?= $contacto['telefono'] ?></td>
                <td><?= $contacto['correo'] ?></td>
                <td><?= $contacto['ciudad'] ?></td>
                <td>
                    <a href="contacto_editar.php?id=<?= $contacto['id'] ?>" class="btn btn-editar">Editar</a>
                    <a href="contacto_eliminar.php?id=<?= $contacto['id'] ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este contacto?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="sin-contactos">No tienes contactos registrados. ¡Agrega el primero!</p>
    <?php endif; ?>
</body>
</html>