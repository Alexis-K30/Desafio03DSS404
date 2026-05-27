@extends('layouts.app')

@section('title', 'Editar Tarea – DataAuditLabs')

@section('content')

<div class="page-header mb-4">
    <a href="{{ route('tareas.index') }}" class="btn-back">
        <i class="bi bi-arrow-left me-1"></i> Volver a mis tareas
    </a>
    <h2 class="page-title mt-2">Editar Tarea</h2>
</div>

@if($errors->any())
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <ul class="mb-0 ps-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <form method="POST" action="{{ route('tareas.update', $tarea->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" id="titulo" name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       placeholder="Ej: Revisar reportes Q2"
                       value="{{ old('titulo', $tarea->titulo) }}"
                       required autofocus maxlength="200">
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      class="form-control" rows="4"
                      placeholder="Describe los detalles de la tarea...">{{ old('descripcion', $tarea->descripcion) }}</textarea>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-select">
                    @foreach($estados as $key => $label)
                        <option value="{{ $key }}" {{ old('estado', $tarea->estado) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Puedes cambiar a cualquier estado libremente.</div>
            </div>
            <div class="col-md-6">
                <label for="fecha_limite" class="form-label">Fecha límite</label>
                <input type="date" id="fecha_limite" name="fecha_limite"
                       class="form-control @error('fecha_limite') is-invalid @enderror"
                       value="{{ old('fecha_limite', $tarea->fecha_limite?->format('Y-m-d')) }}"
                       onclick="this.showPicker()">
                <div class="form-text">Deja vacío para quitar la fecha límite.</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn dal-btn-primary">
                <i class="bi bi-save me-1"></i> Guardar cambios
            </button>
            <a href="{{ route('tareas.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>
        </div>

    </form>
</div>


@push('scripts')
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) !important;
        cursor: pointer;
    }
</style>
<script>
    document.querySelectorAll('input[type="date"]').forEach(input => {
        // Bloquear fechas pasadas
        const hoy = new Date().toISOString().split('T')[0];
        input.min = hoy;
        // Abrir calendario al hacer click/focus
        input.addEventListener('focus', function () { this.showPicker(); });
    });
</script>
@endpush
@endsection