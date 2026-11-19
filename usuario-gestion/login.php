<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; font-size: 16px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; font-size: 16px; cursor: pointer; }
        .error { color: red; background: #ffebee; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>🔐 Iniciar Sesión</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php 
            if ($_GET['error'] == 'credenciales') echo "❌ Correo o contraseña incorrectos.";
            if ($_GET['error'] == 'vacio') echo "⚠️ Completa todos los campos.";
            ?>
        </div>
    <?php endif; ?>

    <form action="autenticar.php" method="POST">
        <div class="form-group">
            <label>Correo electrónico:</label>
            <input type="email" name="correo" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tienes cuenta? <a href="registrar.php">Registrarme</a></p>
</body>
</html>