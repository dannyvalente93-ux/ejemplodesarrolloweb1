<?php require 'config.php';

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    // Validación en el servidor
    if (empty($nombre) || empty($correo) || empty($password)) {
        $error = "⚠️ Todos los campos son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Ingresa un correo electrónico válido.";
    } else {
        // Verificar si el correo ya existe
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "⚠️ Este correo ya está registrado. Usa otro o inicia sesión.";
        } else {
            // Usar password_hash() como pide la seguridad
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $correo, $password_hash);
            
            if ($stmt->execute()) {
                $exito = "✅ Registro exitoso. Ya puedes <a href='login.php'>iniciar sesión</a>.";
            } else {
                $error = "❌ Error al registrar. Inténtalo más tarde.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; font-size: 16px; }
        button { background: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; font-size: 16px; cursor: pointer; }
        .error { color: red; background: #ffebee; padding: 10px; border-radius: 4px; }
        .exito { color: green; background: #e8f5e9; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>📝 Crear Cuenta</h2>
    
    <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <?php if ($exito): ?><div class="exito"><?= $exito ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre completo:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Correo electrónico:</label>
            <input type="email" name="correo" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Registrarme</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
</body>
</html>