@extends('layouts.app')

@section('title', 'Mis Tareas – DataAuditLabs')

@section('content')

@php
    $estadoConfig = [
        'pendiente'   => ['badge' => 'badge-pendiente',   'icon' => 'bi-clock',             'label' => 'Pendiente'],
        'en_progreso' => ['badge' => 'badge-en-progreso',  'icon' => 'bi-arrow-repeat',      'label' => 'En progreso'],
        'completada'  => ['badge' => 'badge-completada',   'icon' => 'bi-check-circle-fill', 'label' => 'Completada'],
        'cancelada'   => ['badge' => 'badge-cancelada',    'icon' => 'bi-x-circle-fill',     'label' => 'Cancelada'],
    ];
    $hoy = \Carbon\Carbon::today()->toDateString();
@endphp

<!-- Encabezado -->
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="page-title">Mis Tareas</h2>
        <p class="page-subtitle">
            {{ $tareas->count() }} tarea{{ $tareas->count() !== 1 ? 's' : '' }} registrada{{ $tareas->count() !== 1 ? 's' : '' }}
        </p>
    </div>
    <a href="{{ route('tareas.create') }}" class="btn dal-btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva tarea
    </a>
</div>

<!-- Alertas flash -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Toast AJAX -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="ajaxToast" class="toast align-items-center border-0" role="alert" aria-live="assertive">
        <div class="d-flex">
            <div class="toast-body" id="ajaxToastMsg">Estado actualizado.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

@if($tareas->isEmpty())
    <div class="empty-state text-center py-5">
        <i class="bi bi-inbox empty-icon"></i>
        <h4 class="mt-3">Aún no tienes tareas</h4>
        <p>Crea tu primera tarea para empezar a organizarte.</p>
        <a href="{{ route('tareas.create') }}" class="btn dal-btn-primary mt-2">
            <i class="bi bi-plus-lg me-1"></i> Crear primera tarea
        </a>
    </div>

@else
    <div class="row g-3">
        @foreach($tareas as $tarea)
            @php
                $cfg       = $estadoConfig[$tarea->estado] ?? $estadoConfig['pendiente'];
                $fechaStr  = $tarea->fecha_limite?->toDateString();
                $vencida   = $fechaStr && $fechaStr < $hoy
                             && !in_array($tarea->estado, ['completada', 'cancelada']);
                $porVencer = $fechaStr && $fechaStr === $hoy
                             && !in_array($tarea->estado, ['completada', 'cancelada']);
            @endphp

            <div class="col-12 col-md-6 col-xl-4">
                <div class="tarea-card {{ $vencida ? 'tarea-vencida' : ($porVencer ? 'tarea-por-vencer' : '') }}" id="tarea-card-{{ $tarea->id }}" data-vencida="{{ $vencida ? '1' : '0' }}" data-por-vencer="{{ $porVencer ? '1' : '0' }}">

                    <!-- Cabecera -->
                    <div class="tarea-card-header">
                        <span class="badge {{ $cfg['badge'] }}" id="badge-{{ $tarea->id }}">
                            <i class="bi {{ $cfg['icon'] }} me-1"></i>
                            <span class="badge-label">{{ $cfg['label'] }}</span>
                        </span>
                        @if($vencida)
                            <span class="badge badge-vencida ms-1">
                                <i class="bi bi-exclamation-circle me-1"></i>Vencida
                            </span>
                        @elseif($porVencer)
                            <span class="badge badge-por-vencer ms-1">
                                <i class="bi bi-alarm me-1"></i>Por vencer
                            </span>
                        @endif
                    </div>

                    <!-- Cuerpo -->
                    <div class="tarea-card-body">
                        <h5 class="tarea-titulo">{{ $tarea->titulo }}</h5>
                        @if($tarea->descripcion)
                            <p class="tarea-desc">{{ $tarea->descripcion }}</p>
                        @endif
                        @if($tarea->fecha_limite)
                            <p class="tarea-fecha">
                                <i class="bi bi-calendar-event me-1"></i>
                                Límite: {{ $tarea->fecha_limite->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>

                    <!-- Cambio de estado AJAX -->
                    <div class="tarea-estado-select mb-3 px-3">
                        <label class="form-label small text-muted mb-1">Cambiar estado</label>
                        <select class="form-select form-select-sm estado-select"
                                data-id="{{ $tarea->id }}"
                                data-url="{{ route('tareas.estado', $tarea->id) }}">
                            @foreach($estados as $key => $label)
                                <option value="{{ $key }}" {{ $tarea->estado === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Acciones -->
                    <div class="tarea-card-actions">
                        <a href="{{ route('tareas.edit', $tarea->id) }}" class="btn btn-sm btn-action-edit">
                            <i class="bi bi-pencil me-1"></i>Editar
                        </a>
                        <form method="POST" action="{{ route('tareas.destroy', $tarea->id) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta tarea? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-action-delete">
                                <i class="bi bi-trash me-1"></i>Eliminar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const ESTADO_CONFIG = {
        pendiente:   { badge: 'badge-pendiente',   icon: 'bi-clock',             label: 'Pendiente'   },
        en_progreso: { badge: 'badge-en-progreso',  icon: 'bi-arrow-repeat',      label: 'En progreso' },
        completada:  { badge: 'badge-completada',   icon: 'bi-check-circle-fill', label: 'Completada'  },
        cancelada:   { badge: 'badge-cancelada',    icon: 'bi-x-circle-fill',     label: 'Cancelada'   },
    };

    const ALL_BADGES = Object.values(ESTADO_CONFIG).map(c => c.badge);

    const toastEl  = document.getElementById('ajaxToast');
    const toastMsg = document.getElementById('ajaxToastMsg');
    const bsToast  = toastEl ? new bootstrap.Toast(toastEl, { delay: 2800 }) : null;

    function showToast(mensaje, ok = true) {
        if (!toastEl || !bsToast) return;
        toastEl.classList.remove('toast-ok', 'toast-error');
        toastEl.classList.add(ok ? 'toast-ok' : 'toast-error');
        toastMsg.textContent = mensaje;
        bsToast.show();
    }

    function actualizarBadge(id, estado) {
        // 1. Actualizar badge de estado (color + ícono + texto)
        const cfg   = ESTADO_CONFIG[estado];
        const badge = document.querySelector(`#badge-${id}`);
        if (!badge || !cfg) return;
        ALL_BADGES.forEach(b => badge.classList.remove(b));
        badge.classList.add(cfg.badge);
        const iconEl  = badge.querySelector('i');
        const labelEl = badge.querySelector('.badge-label');
        if (iconEl)  iconEl.className = `bi ${cfg.icon} me-1`;
        if (labelEl) labelEl.textContent = cfg.label;

        // 2. Mostrar u ocultar badge de vencimiento según el nuevo estado
        const finalizado = ['completada', 'cancelada'].includes(estado);
        const card       = document.querySelector(`#tarea-card-${id}`);
        if (!card) return;

        const esVencida   = card.dataset.vencida    === '1';
        const esPorVencer = card.dataset.porVencer  === '1';
        const header      = card.querySelector('.tarea-card-header');

        // Buscar badges existentes
        let badgeVencida   = card.querySelector('.badge-vencida');
        let badgePorVencer = card.querySelector('.badge-por-vencer');

        if (finalizado) {
            // Ocultar badges de vencimiento y quitar borde de la card
            if (badgeVencida)   badgeVencida.style.display   = 'none';
            if (badgePorVencer) badgePorVencer.style.display = 'none';
            card.classList.remove('tarea-vencida', 'tarea-por-vencer');
        } else {
            // El estado vuelve a activo: restaurar o crear el badge si aplica
            if (esVencida) {
                if (badgeVencida) {
                    badgeVencida.style.display = '';
                } else if (header) {
                    // Recrear el badge si no existe en el DOM
                    const span = document.createElement('span');
                    span.className = 'badge badge-vencida ms-1';
                    span.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Vencida';
                    header.appendChild(span);
                }
                card.classList.add('tarea-vencida');
                card.classList.remove('tarea-por-vencer');
            } else if (esPorVencer) {
                if (badgePorVencer) {
                    badgePorVencer.style.display = '';
                } else if (header) {
                    const span = document.createElement('span');
                    span.className = 'badge badge-por-vencer ms-1';
                    span.innerHTML = '<i class="bi bi-alarm me-1"></i>Por vencer';
                    header.appendChild(span);
                }
                card.classList.add('tarea-por-vencer');
                card.classList.remove('tarea-vencida');
            }
        }
    }

    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', async function () {
            const id     = this.dataset.id;
            const url    = this.dataset.url;
            const estado = this.value;

            this.disabled = true;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ estado }),
                });

                const data = await response.json();

                if (data.ok) {
                    actualizarBadge(id, estado);
                    showToast(`Estado cambiado a "${data.estadoLabel}"`, true);
                } else {
                    showToast('Error al actualizar el estado.', false);
                    window.location.reload();
                }

            } catch (err) {
                console.error('Error AJAX:', err);
                showToast('Error de conexión. Intenta de nuevo.', false);
                window.location.reload();
            } finally {
                this.disabled = false;
            }
        });
    });

});
</script>
@endpush