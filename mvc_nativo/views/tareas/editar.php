<?php
/**
 * @var array  $tarea
 * @var array  $estados
 * @var string|null $error
 */
$pageTitle = 'Editar Tarea – DataAuditLabs';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="page-header mb-4">
    <a href="index.php?ruta=tareas" class="btn-back">
        <i class="bi bi-arrow-left me-1"></i> Volver a mis tareas
    </a>
    <h2 class="page-title mt-2">Editar Tarea</h2>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?ruta=tareas/actualizar" novalidate>

        <!-- ID oculto para identificar la tarea -->
        <input type="hidden" name="id" value="<?= (int) $tarea['id'] ?>">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
            <input type="text" id="titulo" name="titulo"
                   class="form-control"
                   placeholder="Ej: Revisar reportes Q2"
                   value="<?= htmlspecialchars($tarea['titulo']) ?>"
                   required autofocus maxlength="200">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      class="form-control" rows="4"
                      placeholder="Describe los detalles de la tarea..."><?= htmlspecialchars($tarea['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-select">
                    <?php foreach ($estados as $key => $label): ?>
                        <option value="<?= $key ?>"
                            <?= $tarea['estado'] === $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Puedes cambiar a cualquier estado libremente.</div>
            </div>
            <div class="col-md-6">
                <label for="fecha_limite" class="form-label">Fecha límite</label>
                <input type="date" id="fecha_limite" name="fecha_limite"
                       class="form-control"
                       value="<?= htmlspecialchars($tarea['fecha_limite'] ?? '') ?>">
                <div class="form-text">Deja vacío para quitar la fecha límite.</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn dal-btn-primary">
                <i class="bi bi-save me-1"></i> Guardar cambios
            </button>
            <a href="index.php?ruta=tareas" class="btn btn-outline-secondary">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>