<?php
/**
 * @var array $tareas
 * @var array $estados
 * @var string|null $success
 * @var string|null $error
 */
$pageTitle = 'Mis Tareas – DataAuditLabs';
require_once __DIR__ . '/../layouts/header.php';

// Colores y badges por estado
$estadoConfig = [
    'pendiente'   => ['badge' => 'badge-pendiente',   'icon' => 'bi-clock',             'label' => 'Pendiente'],
    'en_progreso' => ['badge' => 'badge-en-progreso',  'icon' => 'bi-arrow-repeat',      'label' => 'En progreso'],
    'completada'  => ['badge' => 'badge-completada',   'icon' => 'bi-check-circle-fill', 'label' => 'Completada'],
    'cancelada'   => ['badge' => 'badge-cancelada',    'icon' => 'bi-x-circle-fill',     'label' => 'Cancelada'],
];
?>

<!-- Encabezado de sección -->
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="page-title">Mis Tareas</h2>
        <p class="page-subtitle">
            <?= count($tareas) ?> tarea<?= count($tareas) !== 1 ? 's' : '' ?> registrada<?= count($tareas) !== 1 ? 's' : '' ?>
        </p>
    </div>
    <a href="index.php?ruta=tareas/crear" class="btn dal-btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva tarea
    </a>
</div>

<!-- Alertas flash -->
<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Toast de AJAX -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="ajaxToast" class="toast align-items-center border-0" role="alert" aria-live="assertive">
        <div class="d-flex">
            <div class="toast-body" id="ajaxToastMsg">Estado actualizado.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<?php if (empty($tareas)): ?>
    <!-- Estado vacío -->
    <div class="empty-state text-center py-5">
        <i class="bi bi-inbox empty-icon"></i>
        <h4 class="mt-3">Aún no tienes tareas</h4>
        <p>Crea tu primera tarea para empezar a organizarte.</p>
        <a href="index.php?ruta=tareas/crear" class="btn dal-btn-primary mt-2">
            <i class="bi bi-plus-lg me-1"></i> Crear primera tarea
        </a>
    </div>

<?php else: ?>
    <div class="row g-3">
        <?php foreach ($tareas as $tarea): ?>
            <?php
                $cfg         = $estadoConfig[$tarea['estado']] ?? $estadoConfig['pendiente'];
                $hoy         = date('Y-m-d');
                $vencida     = $tarea['fecha_limite'] && $tarea['fecha_limite'] < $hoy
                               && $tarea['estado'] !== 'completada'
                               && $tarea['estado'] !== 'cancelada';
                $porVencer   = $tarea['fecha_limite'] && $tarea['fecha_limite'] === $hoy
                               && $tarea['estado'] !== 'completada'
                               && $tarea['estado'] !== 'cancelada';
            ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="tarea-card <?= $vencida ? 'tarea-vencida' : ($porVencer ? 'tarea-por-vencer' : '') ?>" id="tarea-card-<?= $tarea['id'] ?>">

                    <!-- Cabecera de la card -->
                    <div class="tarea-card-header">
                        <span class="badge <?= $cfg['badge'] ?>" id="badge-<?= $tarea['id'] ?>">
                            <i class="bi <?= $cfg['icon'] ?> me-1"></i>
                            <span class="badge-label"><?= $cfg['label'] ?></span>
                        </span>
                        <?php if ($vencida): ?>
                            <span class="badge badge-vencida ms-1">
                                <i class="bi bi-exclamation-circle me-1"></i>Vencida
                            </span>
                        <?php elseif ($porVencer): ?>
                            <span class="badge badge-por-vencer ms-1">
                                <i class="bi bi-alarm me-1"></i>Por vencer
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Cuerpo -->
                    <div class="tarea-card-body">
                        <h5 class="tarea-titulo"><?= htmlspecialchars($tarea['titulo']) ?></h5>
                        <?php if (!empty($tarea['descripcion'])): ?>
                            <p class="tarea-desc"><?= nl2br(htmlspecialchars($tarea['descripcion'])) ?></p>
                        <?php endif; ?>
                        <?php if ($tarea['fecha_limite']): ?>
                            <p class="tarea-fecha">
                                <i class="bi bi-calendar-event me-1"></i>
                                Límite: <?= date('d/m/Y', strtotime($tarea['fecha_limite'])) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Cambio de estado AJAX -->
                    <div class="tarea-estado-select mb-3 px-3">
                        <label class="form-label small text-muted mb-1">Cambiar estado</label>
                        <select class="form-select form-select-sm estado-select"
                                data-id="<?= $tarea['id'] ?>">
                            <?php foreach ($estados as $key => $label): ?>
                                <option value="<?= $key ?>"
                                    <?= $tarea['estado'] === $key ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Acciones -->
                    <div class="tarea-card-actions">
                        <a href="index.php?ruta=tareas/editar&id=<?= $tarea['id'] ?>"
                           class="btn btn-sm btn-action-edit">
                            <i class="bi bi-pencil me-1"></i>Editar
                        </a>
                        <form method="POST" action="index.php?ruta=tareas/eliminar"
                              class="form-delete d-inline"
                              onsubmit="return confirm('¿Eliminar esta tarea? Esta acción no se puede deshacer.')">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-action-delete">
                                <i class="bi bi-trash me-1"></i>Eliminar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>