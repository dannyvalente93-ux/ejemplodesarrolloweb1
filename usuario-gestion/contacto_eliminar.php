<?php
require 'config.php';
verificarSesion();

if (!isset($_GET['id'])) {
    header("Location: panel.php");
    exit();
}

$id = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];

// Verificar que el contacto pertenece al usuario
$stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id, $id_usuario);
$stmt->execute();
$stmt->close();

header("Location: panel.php");
exit();
?>