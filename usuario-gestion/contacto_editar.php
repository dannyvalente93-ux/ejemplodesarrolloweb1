<?php
require 'config.php';
verificarSesion();

// Verificar que el contacto pertenece al usuario
if (!isset($_GET['id'])) {
    header("Location: panel.php");
    exit();
}

$id = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];

// Obtener datos del contacto
$stmt = $conexion->prepare("SELECT * FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "❌ Contacto no encontrado o no tienes permiso.";
    exit();
}

$contacto = $resultado->fetch_assoc();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $ciudad = trim($_POST['ciudad']);

    if (empty($nombre) || empty($telefono) || empty($correo) || empty($ciudad)) {
        $error = "⚠️ Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare("UPDATE contactos SET nombre=?, telefono=?, correo=?, ciudad=? WHERE id=? AND id_usuario=?");
        $stmt->bind_param("ssssii", $nombre, $telefono, $correo, $ciudad, $id, $id_usuario);
        
        if ($stmt->execute()) {
            header("Location: panel.php");
            exit();
        } else {
            $error = "❌ Error al actualizar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contacto</title>
    <style>
        body { font-family