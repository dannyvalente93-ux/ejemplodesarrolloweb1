<<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (empty($correo) || empty($password)) {
        header("Location: login.php?error=vacio");
        exit();
    }

    // Buscar usuario
    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre, $password_hash);
        $stmt->fetch();

        // Usar password_verify() como pide la seguridad
        if (password_verify($password, $password_hash)) {
            // Crear sesión
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            
            header("Location: panel.php");
            exit();
        }
    }
    $stmt->close();
    
    // Credenciales incorrectas
    header("Location: login.php?error=credenciales");
    exit();
}
?>