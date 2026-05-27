// ============================================================
//  DataAuditLabs – app.js
//  AJAX: cambio de estado + actualización en vivo de badges
//  (Pendiente, Por Vencer, Vencida)
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

    // Configuración de badges por estado
    const ESTADO_CONFIG = {
        pendiente:   { badge: 'badge-pendiente',   icon: 'bi-clock',             label: 'Pendiente'   },
        en_progreso: { badge: 'badge-en-progreso',  icon: 'bi-arrow-repeat',      label: 'En progreso' },
        completada:  { badge: 'badge-completada',   icon: 'bi-check-circle-fill', label: 'Completada'  },
        cancelada:   { badge: 'badge-cancelada',    icon: 'bi-x-circle-fill',     label: 'Cancelada'   },
    };

    const ALL_BADGES = Object.values(ESTADO_CONFIG).map(c => c.badge);

    // ---- Toast Bootstrap -----------------------------------
    const toastEl  = document.getElementById('ajaxToast');
    const toastMsg = document.getElementById('ajaxToastMsg');
    let bsToast    = toastEl ? new bootstrap.Toast(toastEl, { delay: 2800 }) : null;

    function showToast(mensaje, ok = true) {
        if (!toastEl || !bsToast) return;
        toastEl.classList.remove('toast-ok', 'toast-error');
        toastEl.classList.add(ok ? 'toast-ok' : 'toast-error');
        toastMsg.textContent = mensaje;
        bsToast.show();
    }

    // ====================== ACTUALIZAR BADGE DE ESTADO ======================
    function actualizarBadge(id, estado) {
        const cfg   = ESTADO_CONFIG[estado];
        const badge = document.querySelector(`#badge-${id}`);
        if (!badge || !cfg) return;

        // Quitar todos los colores anteriores
        ALL_BADGES.forEach(b => badge.classList.remove(b));
        badge.classList.add(cfg.badge);

        // Actualizar ícono y texto
        const iconEl  = badge.querySelector('i');
        const labelEl = badge.querySelector('.badge-label');

        if (iconEl) {
            iconEl.className = `bi ${cfg.icon} me-1`;
        }
        if (labelEl) {
            labelEl.textContent = cfg.label;
        }
    }

    // ====================== ACTUALIZAR CARD COMPLETA (NUEVO) ======================
    function actualizarCardVisual(id, estado, esVencida, esPorVencer) {
        const card = document.getElementById(`tarea-card-${id}`);
        if (!card) return;

        // 1. Actualizar el badge principal de estado
        actualizarBadge(id, estado);

        // 2. Limpiar clases y badges de advertencia anteriores
        card.classList.remove('tarea-vencida', 'tarea-por-vencer');

        const header = card.querySelector('.tarea-card-header');
        if (!header) return;

        // Eliminar badges de vencida/por vencer anteriores
        header.querySelectorAll('.badge-vencida, .badge-por-vencer').forEach(el => el.remove());

        // 3. Agregar nuevo indicador según corresponda
        if (esVencida) {
            card.classList.add('tarea-vencida');
            header.insertAdjacentHTML('beforeend', `
                <span class="badge badge-vencida ms-1">
                    <i class="bi bi-exclamation-circle me-1"></i>Vencida
                </span>
            `);
        } 
        else if (esPorVencer) {
            card.classList.add('tarea-por-vencer');
            header.insertAdjacentHTML('beforeend', `
                <span class="badge badge-por-vencer ms-1">
                    <i class="bi bi-alarm me-1"></i>Por vencer
                </span>
            `);
        }
    }

    // ====================== ESCUCHAR CAMBIOS EN EL SELECT ======================
    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', async function () {
            const id     = this.dataset.id;
            const estado = this.value;

            // Deshabilitar visualmente mientras procesa
            this.classList.add('loading');

            try {
                const response = await fetch('index.php?ruta=tareas/cambiar-estado', {
                    method:  'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ id, estado }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.ok) {
                    actualizarCardVisual(id, estado, data.esVencida, data.esPorVencer);
                    showToast(`Estado cambiado a "${data.estadoLabel}"`, true);
                } else {
                    showToast(data.mensaje || 'Error al actualizar el estado.', false);
                    window.location.reload();
                }

            } catch (err) {
                console.error('Error AJAX:', err);
                showToast('Error de conexión. Intenta de nuevo.', false);
                window.location.reload();
            } finally {
                this.classList.remove('loading');
            }
        });
    });

});