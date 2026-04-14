<?php
include 'db.php';

 $pendientes = $conn->query("SELECT * FROM tareas WHERE estado = 0 ORDER BY fecha ASC");
 $completadas = $conn->query("SELECT * FROM tareas WHERE estado = 1 ORDER BY id DESC LIMIT 5");

 $pendientesArr = [];
while ($r = $pendientes->fetch_assoc()) $pendientesArr[] = $r;

 $completadasArr = [];
while ($r = $completadas->fetch_assoc()) $completadasArr[] = $r;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="bg-decor" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="app">

        <header class="app-header">
            <h1>Organizador de Tareas</h1>
            <p>Organiza tus ideas, conquista tus metas.</p>
            <div class="stats-bar">
                <div class="stat">
                    <div class="stat-icon pendiente"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="stat-num" id="stat-pendientes"><?php echo count($pendientesArr); ?></div>
                        <div class="stat-label">Pendientes</div>
                    </div>
                </div>
                <div class="stat">
                    <div class="stat-icon hecha"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="stat-num" id="stat-completadas"><?php echo count($completadasArr); ?></div>
                        <div class="stat-label">Completadas</div>
                    </div>
                </div>
            </div>
        </header>

        <section class="card" aria-label="Nueva tarea">
            <h2 class="card-title"><i class="fa-solid fa-plus"></i> Nueva Tarea</h2>
            <form id="form-tarea" autocomplete="off">
                <div class="form-grid">
                    <div class="field full">
                        <label for="titulo">¿Qué tarea es?</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Ej: Ejercicios de derivadas" required>
                    </div>
                    <div class="field col-3">
                        <label for="materia">Materia / Asignatura</label>
                        <select name="materia" id="materia">
                            <option value="Matemáticas">Matemáticas</option>
                            <option value="Historia">Historia</option>
                            <option value="Ciencias">Ciencias</option>
                            <option value="Lenguaje">Lenguaje</option>
                            <option value="Artes">Artes</option>
                            <option value="Programación">Programación</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="field col-3">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="Tarea">Individual</option>
                            <option value="Examen">Examen / Quiz</option>
                            <option value="Proyecto">Proyecto Final</option>
                            <option value="Exposición">Exposición</option>
                        </select>
                    </div>
                    <div class="field col-3">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad">
                            <option value="Baja">Baja (Sin prisa)</option>
                            <option value="Media" selected>Media (Regular)</option>
                            <option value="Alta">Alta (¡Urgente!)</option>
                        </select>
                    </div>
                    <div class="field full">
                        <label for="descripcion">Descripción o Notas</label>
                        <textarea name="descripcion" id="descripcion" rows="2" placeholder="Ej: Páginas 45-50 del libro..."></textarea>
                    </div>
                    <div class="field">
                        <label for="fecha">Fecha de Entrega</label>
                        <input type="date" name="fecha" id="fecha" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="field" style="display:flex;align-items:flex-end;">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-paper-plane"></i> Guardar Tarea
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section aria-label="Tareas pendientes" style="margin-bottom:1.5rem;">
            <div class="section-header">
                <h2>
                    <i class="fa-solid fa-list-check" style="color:var(--rose);font-size:0.95rem;"></i>
                    Pendientes
                    <span class="count count-rose" id="count-pendientes"><?php echo count($pendientesArr); ?></span>
                </h2>
            </div>
            <div class="task-list" id="lista-pendientes">
                <?php if (empty($pendientesArr)): ?>
                    <div class="empty-state">
                        <i class="fa-regular fa-face-smile-beam"></i>
                        <p>No hay tareas pendientes. ¡Disfruta tu tiempo libre!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php if (!empty($completadasArr)): ?>
        <section class="card" aria-label="Tareas completadas" style="opacity:0.85;">
            <div class="section-header" style="margin-bottom:1rem;">
                <h2>
                    <i class="fa-solid fa-trophy" style="color:var(--cyan);font-size:0.9rem;"></i>
                    Completadas
                    <span class="count count-cyan" id="count-completadas"><?php echo count($completadasArr); ?></span>
                </h2>
                <button class="toggle-btn open" id="toggle-completadas" type="button" aria-label="Mostrar u ocultar completadas">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
            <div class="collapsible" id="contenedor-completadas">
                <div class="task-list" id="lista-completadas"></div>
            </div>
        </section>
        <?php endif; ?>

        <footer class="app-footer">TaskMaster — Tu productividad, sin recargas.</footer>
    </div>

    <div class="modal-overlay" id="modal-eliminar" role="dialog" aria-modal="true" aria-label="Confirmar eliminación">
        <div class="modal-card">
            <div class="modal-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3>Eliminar tarea</h3>
            <p>Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminarla?</p>
            <div class="modal-btns">
                <button class="btn-modal-cancel" id="btn-cancelar-elim" type="button">Cancelar</button>
                <button class="btn-modal-danger" id="btn-confirmar-elim" type="button">Eliminar</button>
            </div>
        </div>
    </div>

    <div id="toast-container" aria-live="polite"></div>

    <script>
    $(function () {

        var datosIniciales = <?php echo json_encode([
            'pendientes'  => $pendientesArr,
            'completadas' => $completadasArr
        ]); ?>;

        renderPendientes(datosIniciales.pendientes);
        renderCompletadas(datosIniciales.completadas);

        function esc(str) {
            if (!str) return '';
            var d = document.createElement('div');
            d.appendChild(document.createTextNode(str));
            return d.innerHTML;
        }

        function hoyStr() {
            var d = new Date();
            return d.getFullYear() + '-' +
                   String(d.getMonth() + 1).padStart(2, '0') + '-' +
                   String(d.getDate()).padStart(2, '0');
        }

        function analizarFecha(fechaStr) {
            var hoy = new Date(); hoy.setHours(0,0,0,0);
            var fecha = new Date(fechaStr + 'T00:00:00');
            var diff = Math.round((fecha - hoy) / 86400000);

            if (diff < 0)  return { texto: 'Vencida hace ' + Math.abs(diff) + ' día' + (Math.abs(diff)>1?'s':''), clase: 'vencida', urgencia: 'u-vencida' };
            if (diff === 0) return { texto: 'Hoy', clase: 'hoy', urgencia: 'u-hoy' };
            if (diff === 1) return { texto: 'Mañana', clase: 'proxima', urgencia: 'u-proxima' };
            if (diff <= 3)  return { texto: 'En ' + diff + ' días', clase: 'proxima', urgencia: 'u-proxima' };

            var opciones = { day: 'numeric', month: 'short' };
            return { texto: fecha.toLocaleDateString('es-ES', opciones), clase: 'normal', urgencia: 'u-normal' };
        }

        function renderPendientes(tareas) {
            var $lista = $('#lista-pendientes');
            $lista.empty();
            if (tareas.length === 0) {
                $lista.html(
                    '<div class="empty-state">' +
                        '<i class="fa-regular fa-face-smile-beam"></i>' +
                        '<p>No hay tareas pendientes. ¡Disfruta tu tiempo libre!</p>' +
                    '</div>'
                );
                return;
            }
            $.each(tareas, function (i, t) {
                var f = analizarFecha(t.fecha);
                var desc = t.descripcion ? '<p class="task-desc">' + esc(t.descripcion) + '</p>' : '';
                $lista.append(
                    '<div class="task-item priority-' + (t.prioridad || 'Media') + ' ' + f.urgencia + '" style="animation-delay:' + (i * 0.04) + 's">' +
                        '<div class="task-info">' +
                            '<div class="task-badges">' +
                                '<span class="badge-materia">' + esc(t.materia || 'General') + '</span>' +
                                '<span class="badge-tipo">' + esc(t.tipo || 'Tarea') + '</span>' +
                            '</div>' +
                            '<h3 class="task-title">' + esc(t.titulo) + '</h3>' +
                            desc +
                            '<span class="task-date f-' + f.clase + '"><i class="fa-regular fa-calendar"></i> ' + f.texto + ' | Prioridad: <strong>' + (t.prioridad || 'Media') + '</strong></span>' +
                        '</div>' +
                        '<div class="task-actions">' +
                            '<button class="act-btn act-check btn-completar" data-id="' + t.id + '" title="Completar"><i class="fa-solid fa-check"></i></button>' +
                            '<button class="act-btn act-del btn-eliminar" data-id="' + t.id + '" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>' +
                        '</div>' +
                    '</div>'
                );
            });
        }

        function renderCompletadas(tareas) {
            var $lista = $('#lista-completadas');
            $lista.empty();
            if (tareas.length === 0) {
                $lista.closest('.card').fadeOut(250);
                return;
            }
            $lista.closest('.card').show();
            $.each(tareas, function (i, t) {
                $lista.append(
                    '<div class="task-item done" style="animation-delay:' + (i * 0.04) + 's">' +
                        '<div class="task-info">' +
                            '<h3 class="task-title">' + esc(t.titulo) + '<span class="done-badge">Logrado</span></h3>' +
                        '</div>' +
                        '<div class="task-actions">' +
                            '<button class="act-btn act-del btn-eliminar" data-id="' + t.id + '" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>' +
                        '</div>' +
                    '</div>'
                );
            });
        }

        function actualizarStats(pendientes, completadas) {
            $('#stat-pendientes').text(pendientes.length);
            $('#stat-completadas').text(completadas.length);
            $('#count-pendientes').text(pendientes.length);
            $('#count-completadas').text(completadas.length);
        }

        function cargarTareas() {
            $.get('tareas.php', { accion: 'listar' }, function (res) {
                if (!res.success) return;
                renderPendientes(res.pendientes);
                renderCompletadas(res.completadas);
                actualizarStats(res.pendientes, res.completadas);
            }, 'json');
        }

        $('#form-tarea').on('submit', function (e) {
            e.preventDefault();
            var titulo = $.trim($('#titulo').val());
            if (!titulo) {
                toast('Escribe un título para la tarea', 'warn');
                $('#titulo').focus();
                return;
            }
            var $btn = $(this).find('.btn-submit');
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Guardando...');

            $.post('tareas.php', {
                accion: 'crear',
                titulo: titulo,
                materia: $('#materia').val(),
                tipo: $('#tipo').val(),
                prioridad: $('#prioridad').val(),
                descripcion: $('#descripcion').val(),
                fecha: $('#fecha').val()
            }, function (res) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane"></i> Guardar Tarea');
                if (res.success) {
                    toast(res.mensaje, 'ok');
                    $('#form-tarea')[0].reset();
                    $('#fecha').val(hoyStr());
                    cargarTareas();
                } else { toast(res.mensaje, 'err'); }
            }, 'json').fail(function () {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane"></i> Guardar Tarea');
                toast('Error de conexión con el servidor', 'err');
            });
        });

        $(document).on('click', '.btn-completar', function () {
            var id = $(this).data('id');
            var $item = $(this).closest('.task-item');
            $item.css({ transition: 'all 0.3s ease', opacity: 0, transform: 'translateX(40px)' });
            $.get('tareas.php', { accion: 'completar', id: id }, function (res) {
                if (res.success) { toast(res.mensaje, 'ok'); cargarTareas(); }
                else { toast(res.mensaje || 'Error al completar', 'err'); $item.css({ opacity: 1, transform: 'none' }); }
            }, 'json').fail(function () {
                toast('Error de conexión', 'err'); $item.css({ opacity: 1, transform: 'none' });
            });
        });

        var idParaEliminar = null;

        $(document).on('click', '.btn-eliminar', function () {
            idParaEliminar = $(this).data('id');
            $('#modal-eliminar').addClass('active');
        });

        $('#btn-cancelar-elim').on('click', function () {
            $('#modal-eliminar').removeClass('active'); idParaEliminar = null;
        });

        $('#modal-eliminar').on('click', function (e) {
            if ($(e.target).is('#modal-eliminar')) { $(this).removeClass('active'); idParaEliminar = null; }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $('#modal-eliminar').hasClass('active')) {
                $('#modal-eliminar').removeClass('active'); idParaEliminar = null;
            }
        });

        $('#btn-confirmar-elim').on('click', function () {
            if (idParaEliminar === null) return;
            var $btn = $(this);
            $btn.prop('disabled', true).text('Eliminando...');
            $.get('tareas.php', { accion: 'eliminar', id: idParaEliminar }, function (res) {
                $btn.prop('disabled', false).text('Eliminar');
                $('#modal-eliminar').removeClass('active');
                if (res.success) { toast(res.mensaje, 'ok'); cargarTareas(); }
                else { toast(res.mensaje || 'Error al eliminar', 'err'); }
                idParaEliminar = null;
            }, 'json').fail(function () {
                $btn.prop('disabled', false).text('Eliminar');
                $('#modal-eliminar').removeClass('active');
                toast('Error de conexión', 'err'); idParaEliminar = null;
            });
        });

        $('#toggle-completadas').on('click', function () {
            $(this).toggleClass('open');
            $('#contenedor-completadas').toggleClass('collapsed');
        });

        function toast(mensaje, tipo) {
            var iconos  = { ok: 'fa-solid fa-circle-check', err: 'fa-solid fa-circle-xmark', warn: 'fa-solid fa-circle-exclamation' };
            var colores = { ok: 'var(--success)', err: 'var(--danger)', warn: 'var(--amber)' };
            var $t = $('<div class="toast"><i class="' + (iconos[tipo]||iconos.ok) + '" style="color:' + (colores[tipo]||colores.ok) + '"></i><span>' + esc(mensaje) + '</span></div>');
            $('#toast-container').append($t);
            $t[0].offsetWidth;
            $t.addClass('visible');
            setTimeout(function () { $t.removeClass('visible'); setTimeout(function () { $t.remove(); }, 350); }, 3000);
        }

    });
    </script>
</body>
</html>