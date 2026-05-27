<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro – DataAuditLabs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dal-bg: #0f1117; --dal-surface: #1a1d27; --dal-surface-2: #22263a;
            --dal-border: #2e3350; --dal-accent: #c8f135; --dal-accent-dark: #a8d020;
            --dal-text: #e8eaf0; --dal-text-muted: #8891b0; --dal-danger: #ff4d6d;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background-color: var(--dal-bg); color: var(--dal-text); min-height: 100vh; margin: 0; }
        h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }
        .auth-wrapper { display: flex; min-height: 100vh; }
        .auth-panel-left { width: 45%; background: linear-gradient(135deg, #1a1d27 0%, #0f1117 60%); border-right: 1px solid var(--dal-border); display: flex; align-items: center; justify-content: center; padding: 3rem; position: relative; overflow: hidden; }
        .auth-panel-left::before { content: ''; position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, rgba(200,241,53,0.08) 0%, transparent 70%); top: -50px; right: -50px; border-radius: 50%; }
        .auth-panel-content { position: relative; z-index: 1; }
        .auth-logo-big { font-size: 3rem; color: var(--dal-accent); margin-bottom: 1rem; }
        .auth-headline { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 2.5rem; line-height: 1.1; margin-bottom: 1rem; }
        .auth-headline span { color: var(--dal-accent); }
        .auth-tagline { color: var(--dal-text-muted); font-size: 1rem; margin-bottom: 2rem; line-height: 1.6; }
        .auth-features { list-style: none; padding: 0; margin: 0; }
        .auth-features li { color: var(--dal-text-muted); font-size: .9rem; margin-bottom: .6rem; display: flex; align-items: center; gap: .5rem; }
        .auth-features li i { color: var(--dal-accent); }
        .auth-panel-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .auth-form-box { width: 100%; max-width: 420px; }
        .auth-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.8rem; margin-bottom: .25rem; }
        .auth-subtitle { color: var(--dal-text-muted); font-size: .9rem; margin-bottom: 1.5rem; }
        .auth-switch { text-align: center; margin-top: 1.5rem; font-size: .88rem; color: var(--dal-text-muted); }
        .auth-switch a { color: var(--dal-accent); text-decoration: none; font-weight: 600; }
        .auth-switch a:hover { text-decoration: underline; }
        .form-label { font-size: .88rem; font-weight: 500; color: var(--dal-text-muted); margin-bottom: .3rem; }
        .form-control { background-color: var(--dal-surface-2); border-color: var(--dal-border); color: var(--dal-text); border-radius: 8px; }
        .form-control:focus { background-color: var(--dal-surface-2); border-color: var(--dal-accent); color: var(--dal-text); box-shadow: 0 0 0 .15rem rgba(200,241,53,.2); }
        .form-control::placeholder { color: var(--dal-text-muted); opacity: .7; }
        .input-group-text { background-color: var(--dal-surface-2); border-color: var(--dal-border); color: var(--dal-text-muted); }
        .dal-btn-primary { background-color: var(--dal-accent); color: #0f1117; font-weight: 700; font-family: 'Syne', sans-serif; border: none; border-radius: 8px; padding: .5rem 1.2rem; transition: background-color .2s, transform .1s; }
        .dal-btn-primary:hover { background-color: var(--dal-accent-dark); color: #0f1117; transform: translateY(-1px); }
        .alert-danger { background-color: rgba(255,77,109,.1); border-color: var(--dal-danger); color: var(--dal-danger); }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-panel-left d-none d-lg-flex">
        <div class="auth-panel-content">
            <div class="auth-logo-big"><i class="bi bi-clipboard2-check-fill"></i></div>
            <h1 class="auth-headline">DataAudit<br><span>Labs</span></h1>
            <p class="auth-tagline">Únete al equipo y empieza<br>a organizar tus tareas hoy.</p>
            <ul class="auth-features">
                <li><i class="bi bi-check2-circle"></i> Cuenta personal y privada</li>
                <li><i class="bi bi-check2-circle"></i> Acceso desde cualquier lugar</li>
                <li><i class="bi bi-check2-circle"></i> Seguro y sin complicaciones</li>
            </ul>
        </div>
    </div>
    <div class="auth-panel-right">
        <div class="auth-form-box">
            <h2 class="auth-title">Crear cuenta</h2>
            <p class="auth-subtitle">Completa el formulario para registrarte</p>

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="name" name="name" class="form-control"
                               placeholder="Juan Pérez"
                               value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="usuario@empresa.com"
                               value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Mínimo 8 caracteres" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Repite tu contraseña" required>
                    </div>
                </div>
                <button type="submit" class="btn dal-btn-primary w-100">
                    <i class="bi bi-person-plus me-2"></i>Crear cuenta
                </button>
            </form>

            <p class="auth-switch">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>