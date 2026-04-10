<?php
// Conexion simple
$conn = new mysqli("localhost", "root", "", "nombre_tu_bd");

// 1. Lógica para Insertar (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $desc   = $_POST['descripcion'];
    $fecha  = $_POST['fecha'];
    
    $conn->query("INSERT INTO tareas (titulo, descripcion, fecha) VALUES ('$titulo', '$desc', '$fecha')");
    header("Location: index.php"); // Recarga para ver cambios
}

// 2. Lógica para Completar (GET)
if (isset($_GET['completar'])) {
    $id = $_GET['completar'];
    $conn->query("UPDATE tareas SET estado = 1 WHERE id = $id");
    header("Location: index.php");
}

// 3. Consulta para Christopher (PENDIENTES)
$pendientes = $conn->query("SELECT * FROM tareas WHERE estado = 0");
?>