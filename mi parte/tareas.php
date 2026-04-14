<?php
header('Content-Type: application/json; charset=utf-8');
include 'db.php';

 $accion = $_REQUEST['accion'] ?? '';

switch ($accion) {

    case 'crear':
        $titulo    = $conn->real_escape_string($_POST['titulo'] ?? '');
        $materia   = $conn->real_escape_string($_POST['materia'] ?? 'General');
        $tipo      = $conn->real_escape_string($_POST['tipo'] ?? 'Tarea');
        $desc      = $conn->real_escape_string($_POST['descripcion'] ?? '');
        $prioridad = $conn->real_escape_string($_POST['prioridad'] ?? 'Media');
        $fecha     = $conn->real_escape_string($_POST['fecha'] ?? date('Y-m-d'));

        if (trim($titulo) === '') {
            echo json_encode(['success' => false, 'mensaje' => 'El título es obligatorio']);
            exit;
        }

        $conn->query("INSERT INTO tareas (titulo, materia, tipo, descripcion, prioridad, fecha, estado) VALUES ('$titulo', '$materia', '$tipo', '$desc', '$prioridad', '$fecha', 0)");
        echo json_encode(['success' => true, 'mensaje' => 'Tarea creada correctamente']);
        break;

    case 'completar':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) { echo json_encode(['success' => false, 'mensaje' => 'ID inválido']); exit; }
        $conn->query("UPDATE tareas SET estado = 1 WHERE id = $id");
        echo json_encode(['success' => true, 'mensaje' => 'Tarea completada']);
        break;

    case 'eliminar':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) { echo json_encode(['success' => false, 'mensaje' => 'ID inválido']); exit; }
        $conn->query("DELETE FROM tareas WHERE id = $id");
        echo json_encode(['success' => true, 'mensaje' => 'Tarea eliminada']);
        break;

    case 'listar':
        $resP = $conn->query("SELECT * FROM tareas WHERE estado = 0 ORDER BY fecha ASC");
        $resC = $conn->query("SELECT * FROM tareas WHERE estado = 1 ORDER BY id DESC LIMIT 5");

        $pendientes = [];
        while ($r = $resP->fetch_assoc()) $pendientes[] = $r;

        $completadas = [];
        while ($r = $resC->fetch_assoc()) $completadas[] = $r;

        echo json_encode(['success' => true, 'pendientes' => $pendientes, 'completadas' => $completadas]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'mensaje' => 'Acción no válida']);
}