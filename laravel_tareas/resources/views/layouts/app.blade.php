<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DataAuditLabs')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dal-bg: #0f1117; --dal-surface: #1a1d27; --dal-surface-2: #22263a;
            --dal-border: #2e3350; --dal-accent: #c8f135; --dal-accent-dark: #a8d020;
            --dal-text: #e8eaf0; --dal-text-muted: #8891b0; --dal-danger: #ff4d6d;
            --dal-warning: #f4a261; --dal-success: #52d9a0; --dal-info: #4fc3f7;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background-color: var(--dal-bg); color: var(--dal-text); min-height: 100vh; }
        h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

        /* Navbar */
        .dal-navbar { background-color: var(--dal-surface); border-bottom: 1px solid var(--dal-border); padding: .75rem 0; }
        .dal-brand { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.3rem; color: var(--dal-text) !important; text-decoration: none; display: flex; align-items: center; gap: .5rem; }
        .brand-icon { color: var(--dal-accent); font-size: 1.4rem; }
        .brand-accent { color: var(--dal-accent); }
        .dal-navbar .nav-link { color: var(--dal-text-muted) !important; font-size: .9rem; transition: color .2s; padding: .4rem .6rem; }
        .dal-navbar .nav-link:hover { color: var(--dal-accent) !important; }
        .nav-user { font-size: .85rem; color: var(--dal-text-muted); border: 1px solid var(--dal-border); border-radius: 20px; padding: .3rem .8rem; }
        .btn-logout { font-size: .85rem; color: var(--dal-danger) !important; border: 1px solid var(--dal-danger); border-radius: 20px; padding: .3rem .8rem; transition: all .2s; text-decoration: none; cursor: pointer; background: transparent; }
        .btn-logout:hover { background-color: var(--dal-danger); color: #fff !important; }
        .navbar-toggler { border-color: var(--dal-accent) !important; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23c8f135' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important; }

        /* Main / Footer */
        .dal-main { padding: 1.5rem 0; min-height: calc(100vh - 130px); }
        .dal-footer { background-color: var(--dal-surface); border-top: 1px solid var(--dal-border); padding: 1rem 0; font-size: .82rem; color: var(--dal-text-muted); }

        /* Botón principal */
        .dal-btn-primary { background-color: var(--dal-accent); color: #0f1117; font-weight: 700; font-family: 'Syne', sans-serif; border: none; border-radius: 8px; padding: .5rem 1.2rem; transition: background-color .2s, transform .1s; }
        .dal-btn-primary:hover { background-color: var(--dal-accent-dark); color: #0f1117; transform: translateY(-1px); }

        /* Page header */
        .page-title { font-size: 1.6rem; font-weight: 800; margin: 0; }
        .page-subtitle { color: var(--dal-text-muted); margin: 0; font-size: .9rem; }
        .btn-back { color: var(--dal-text-muted); text-decoration: none; font-size: .88rem; transition: color .2s; }
        .btn-back:hover { color: var(--dal-accent); }

        /* Cards */
        .tarea-card { background-color: var(--dal-surface); border: 1px solid var(--dal-border); border-radius: 12px; overflow: hidden; transition: transform .2s, box-shadow .2s, border-color .2s; height: 100%; display: flex; flex-direction: column; }
        .tarea-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.4); border-color: var(--dal-accent); }
        .tarea-vencida { border-color: var(--dal-danger) !important; }
        .tarea-por-vencer { border-color: var(--dal-warning) !important; }
        .tarea-card-header { padding: .75rem 1rem 0; display: flex; flex-wrap: wrap; gap: .4rem; }
        .tarea-card-body { padding: .5rem 1rem .75rem; flex-grow: 1; }
        .tarea-titulo { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: .4rem; }
        .tarea-desc { font-size: .85rem; color: var(--dal-text-muted); margin-bottom: .5rem; line-height: 1.5; }
        .tarea-fecha { font-size: .8rem; color: var(--dal-text-muted); margin: 0; }
        .tarea-card-actions { padding: .75rem 1rem; border-top: 1px solid var(--dal-border); display: flex; gap: .5rem; }

        /* Badges */
        .badge { font-size: .75rem; font-weight: 600; padding: .35rem .65rem; border-radius: 20px; }
        .badge-pendiente   { background-color: rgba(244,162,97,.15);  color: #f4a261; border: 1px solid #f4a261; }
        .badge-en-progreso { background-color: rgba(79,195,247,.15);  color: #4fc3f7; border: 1px solid #4fc3f7; }
        .badge-completada  { background-color: rgba(82,217,160,.15);  color: #52d9a0; border: 1px solid #52d9a0; }
        .badge-cancelada   { background-color: rgba(136,145,176,.15); color: #8891b0; border: 1px solid #8891b0; }
        .badge-vencida     { background-color: rgba(255,77,109,.15);  color: var(--dal-danger); border: 1px solid var(--dal-danger); }
        .badge-por-vencer  { background-color: rgba(244,162,97,.15);  color: var(--dal-warning); border: 1px solid var(--dal-warning); }

        /* Acciones */
        .btn-action-edit { background-color: transparent; border: 1px solid var(--dal-info); color: var(--dal-info); border-radius: 6px; font-size: .82rem; padding: .3rem .7rem; transition: all .2s; }
        .btn-action-edit:hover { background-color: var(--dal-info); color: #0f1117; }
        .btn-action-delete { background-color: transparent; border: 1px solid var(--dal-danger); color: var(--dal-danger); border-radius: 6px; font-size: .82rem; padding: .3rem .7rem; transition: all .2s; }
        .btn-action-delete:hover { background-color: var(--dal-danger); color: #fff; }

        /* Formulario */
        .form-card { background-color: var(--dal-surface); border: 1px solid var(--dal-border); border-radius: 12px; padding: 2rem; max-width: 700px; }
        .form-label { font-size: .88rem; font-weight: 500; color: var(--dal-text-muted); margin-bottom: .3rem; }
        .form-control, .form-select { background-color: var(--dal-surface-2); border-color: var(--dal-border); color: var(--dal-text); border-radius: 8px; }
        .form-control:focus, .form-select:focus { background-color: var(--dal-surface-2); border-color: var(--dal-accent); color: var(--dal-text); box-shadow: 0 0 0 .15rem rgba(200,241,53,.2); }
        .form-control::placeholder { color: var(--dal-text-muted); opacity: .7; }
        .input-group-text { background-color: var(--dal-surface-2); border-color: var(--dal-border); color: var(--dal-text-muted); }
        .form-text { font-size: .78rem; color: var(--dal-text-muted); }

        /* Alertas */
        .alert-danger  { background-color: rgba(255,77,109,.1);  border-color: var(--dal-danger);  color: var(--dal-danger); }
        .alert-success { background-color: rgba(82,217,160,.1);  border-color: var(--dal-success); color: var(--dal-success); }

        /* Empty state */
        .empty-icon { font-size: 4rem; color: var(--dal-text-muted); }

        @media (max-width: 767px) {
            .form-card { padding: 1.25rem; }
            .page-header { flex-direction: column; align-items: flex-start; gap: .75rem; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg dal-navbar">
    <div class="container">
        <a class="navbar-brand dal-brand" href="{{ route('tareas.index') }}">
            <span class="brand-icon"><i class="bi bi-clipboard2-check-fill"></i></span>
            DataAudit<span class="brand-accent">Labs</span>
            <span class="badge bg-secondary ms-2" style="font-size:.6rem;font-family:'DM Sans',sans-serif;font-weight:400;">Laravel</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tareas.index') }}">
                        <i class="bi bi-list-task me-1"></i>Mis Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tareas.create') }}">
                        <i class="bi bi-plus-circle me-1"></i>Nueva Tarea
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <span class="nav-user">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-1"></i>Salir
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="dal-main">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

<footer class="dal-footer">
    <div class="container text-center">
        <span>DataAuditLabs &copy; {{ date('Y') }} &mdash; Versión Laravel</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>