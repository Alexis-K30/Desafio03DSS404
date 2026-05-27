// ============================================================
//  DataAuditLabs – app.js
//  AJAX: cambio de estado de tareas sin recargar la página
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

    // ---- Actualizar badge en la card -----------------------
    function actualizarBadge(id, estado) {
        const cfg   = ESTADO_CONFIG[estado];
        const badge = document.querySelector(`#badge-${id}`);
        if (!badge || !cfg) return;

        // Quitar todos los colores y poner el nuevo
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

    // ---- Escuchar cambios en los selects de estado ---------
    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', async function () {
            const id     = this.dataset.id;
            const estado = this.value;

            // Deshabilitar mientras procesa
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
                    actualizarBadge(id, estado);
                    showToast(`Estado cambiado a "${data.estadoLabel}"`, true);
                } else {
                    showToast(data.mensaje || 'Error al actualizar el estado.', false);
                    // Revertir el select al valor anterior (recargamos la página es lo más seguro)
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