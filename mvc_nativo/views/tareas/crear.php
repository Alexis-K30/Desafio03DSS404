<?php
/**
 * @var array $estados
 * @var string|null $error
 */
$pageTitle = 'Nueva Tarea – DataAuditLabs';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="page-header mb-4">
    <a href="index.php?ruta=tareas" class="btn-back">
        <i class="bi bi-arrow-left me-1"></i> Volver a mis tareas
    </a>
    <h2 class="page-title mt-2">Nueva Tarea</h2>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?ruta=tareas/guardar" novalidate>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
            <input type="text" id="titulo" name="titulo"
                   class="form-control"
                   placeholder="Ej: Revisar reportes Q2"
                   value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                   required autofocus maxlength="200">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      class="form-control" rows="4"
                      placeholder="Describe los detalles de la tarea..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado inicial</label>
                <select id="estado" name="estado" class="form-select">
                    <?php foreach ($estados as $key => $label): ?>
                        <option value="<?= $key ?>"
                            <?= (($_POST['estado'] ?? 'pendiente') === $key) ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fecha_limite" class="form-label">Fecha límite</label>
                <input type="date" id="fecha_limite" name="fecha_limite"
                       class="form-control"
                       value="<?= htmlspecialchars($_POST['fecha_limite'] ?? '') ?>"
                       min="<?= date('Y-m-d') ?>">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn dal-btn-primary">
                <i class="bi bi-save me-1"></i> Guardar tarea
            </button>
            <a href="index.php?ruta=tareas" class="btn btn-outline-secondary">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>