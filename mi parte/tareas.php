<?php
include 'db.php';

// Procesar Nueva Tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $titulo    = $conn->real_escape_string($_POST['titulo']);
    $materia   = $conn->real_escape_string($_POST['materia']);
    $tipo      = $conn->real_escape_string($_POST['tipo']);
    $desc      = $conn->real_escape_string($_POST['descripcion']);
    $prioridad = $conn->real_escape_string($_POST['prioridad']);
    $fecha     = $_POST['fecha'];

    $sql = "INSERT INTO tareas (titulo, materia, tipo, descripcion, prioridad, fecha, estado) 
            VALUES ('$titulo', '$materia', '$tipo', '$desc', '$prioridad', '$fecha', 0)";
    
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Completar Tarea
if (isset($_GET['completar'])) {
    $id = (int)$_GET['completar'];
    $conn->query("UPDATE tareas SET estado = 1 WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Eliminar Tarea
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conn->query("DELETE FROM tareas WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Obtener Tareas
$pendientes = $conn->query("SELECT * FROM tareas WHERE estado = 0 ORDER BY fecha ASC");
$completadas = $conn->query("SELECT * FROM tareas WHERE estado = 1 ORDER BY id DESC LIMIT 5");
?>
