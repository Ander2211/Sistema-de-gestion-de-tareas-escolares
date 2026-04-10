<?php
include 'db.php';


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

if (isset($_GET['completar'])) {
    $id = (int)$_GET['completar'];
    $conn->query("UPDATE tareas SET estado = 1 WHERE id = $id");
    header("Location: index.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conn->query("DELETE FROM tareas WHERE id = $id");
    header("Location: index.php");
    exit();
}

$pendientes = $conn->query("SELECT * FROM tareas WHERE estado = 0 ORDER BY fecha ASC");
$completadas = $conn->query("SELECT * FROM tareas WHERE estado = 1 ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión de tareas escolares</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --low: #22c55e;
            --medium: #f59e0b;
            --high: #ef4444;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            padding-bottom: 50px;
        }
        .container { max-width: 900px; margin-top: 40px; }
        header { text-align: center; margin-bottom: 40px; }
        header h1 { font-weight: 800; color: var(--primary); font-size: 2.5rem; }
        
        .card-custom {
            background: var(--card-bg);
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #64748b; }
        .btn-primary { 
            background: var(--primary); 
            border: none; 
            padding: 12px 25px; 
            border-radius: 12px; 
            font-weight: 600;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .task-item:hover { transform: translateX(5px); }
        .task-item.priority-Alta { border-left-color: var(--high); }
        .task-item.priority-Media { border-left-color: var(--medium); }
        .task-item.priority-Baja { border-left-color: var(--low); }
        
        .badge-materia {
            background: #e0e7ff;
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 8px;
        }
        .badge-tipo {
            background: #f1f5f9;
            color: #475569;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .task-info h3 { font-size: 1.15rem; margin-bottom: 5px; font-weight: 600; }
        .task-info p { color: #64748b; font-size: 0.95rem; margin-bottom: 10px; }
        .task-meta { font-size: 0.85rem; color: #94a3b8; }
        
        .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    </style>
</head>



<body>
    <div class="container">
        <header>
            <h1>Organizador de Tareas</h1>
            <p>Organiza tus ideas, conquista tus metas.</p>
        </header>

        <div class="card-custom">
            <h2 class="h4 mb-4"> Registrar Nueva Actividad</h2>
            <form action="index.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">¿Qué tarea es?</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Ejercicios de derivadas" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Materia / Asignatura</label>
                        <select name="materia" class="form-select">
                            <option value="Matemáticas">Matemáticas</option>
                            <option value="Historia">Historia</option>
                            <option value="Ciencias">Ciencias</option>
                            <option value="Lenguaje">Lenguaje</option>
                            <option value="Artes">Artes</option>
                            <option value="Programación">Programación</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="Tarea">Individual</option>
                            <option value="Examen">Examen / Quiz</option>
                            <option value="Proyecto">Proyecto Final</option>
                            <option value="Exposición">Exposición</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Prioridad</label>
                        <select name="prioridad" class="form-select">
                            <option value="Baja">Baja (Sin prisa)</option>
                            <option value="Media" selected>Media (Regular)</option>
                            <option value="Alta">Alta (¡Urgente!)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Entrega</label>
                        <input type="date" name="fecha" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripción o Notas</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Ej: Páginas 45-50 del libro..."></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mb-5">
            <h2 class="h4 mb-4"> Mis Deberes Pendientes</h2>
            <div class="task-sections">
                <?php if ($pendientes->num_rows > 0): ?>
                    <?php while ($row = $pendientes->fetch_assoc()): ?>
                        <div class="task-item priority-<?php echo $row['prioridad']; ?>">
                            <div class="task-info">
                                <span class="badge-materia"><?php echo htmlspecialchars($row['materia']); ?></span>
                                <span class="badge-tipo"><?php echo htmlspecialchars($row['tipo']); ?></span>
                                <h3 class="mt-2 text-dark"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                                <div class="task-meta">
                                     Entrega: <strong><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></strong> 
                                    |  Prioridad: <strong><?php echo $row['prioridad']; ?></strong>
                                </div>
                            </div>
                            <div class="task-actions d-flex gap-2">
                                <a href="index.php?completar=<?php echo $row['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3">
                                    Listo
                                </a>
                                <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('¿Eliminar esta tarea?')">
                                    Borrar
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="card-custom">
                        <div class="empty-state">
                            <div style="font-size: 3rem;"></div>
                            <p class="mt-3">No tienes pendientes por ahora. </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Completadas Recientemente -->
        <?php if ($completadas->num_rows > 0): ?>
            <div class="card-custom mt-5" style="opacity: 0.8; background: #f1f5f9;">
                <h2 class="h5 mb-4 text-muted"> Logros Recientes</h2>
                <div class="task-list">
                    <?php while ($row = $completadas->fetch_assoc()): ?>
                        <div class="task-item" style="border-left-color: #cbd5e1; background: rgba(255,255,255,0.5);">
                            <div class="task-info">
                                <span class="badge bg-secondary mb-2" style="font-size: 0.6rem; opacity: 0.7;"><?php echo htmlspecialchars($row['materia']); ?></span>
                                <h3 style="text-decoration: line-through; color: #94a3b8; font-size: 1rem;"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            </div>
                            <div class="task-actions">
                                <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-sm btn-light border" title="Eliminar definitivamente">✕</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>