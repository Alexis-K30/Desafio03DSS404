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
    <link href="public/css/app.css" rel="stylesheet">
</head>
<body class="auth-page">
 
<div class="auth-wrapper">
 
    <!-- Panel izquierdo decorativo -->
    <div class="auth-panel-left d-none d-lg-flex">
        <div class="auth-panel-content">
            <div class="auth-logo-big">
                <i class="bi bi-clipboard2-check-fill"></i>
            </div>
            <h1 class="auth-headline">DataAudit<br><span>Labs</span></h1>
            <p class="auth-tagline">Únete al equipo y empieza<br>a organizar tus tareas hoy.</p>
            <ul class="auth-features">
                <li><i class="bi bi-check2-circle"></i> Cuenta personal y privada</li>
                <li><i class="bi bi-check2-circle"></i> Acceso desde cualquier lugar</li>
                <li><i class="bi bi-check2-circle"></i> Seguro y sin complicaciones</li>
            </ul>
        </div>
    </div>
 
    <!-- Panel derecho – formulario -->
    <div class="auth-panel-right">
        <div class="auth-form-box">
 
            <h2 class="auth-title">Crear cuenta</h2>
            <p class="auth-subtitle">Completa el formulario para registrarte</p>
 
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
 
            <form method="POST" action="index.php?ruta=registro" novalidate>
 
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="nombre" name="nombre"
                               class="form-control"
                               placeholder="Juan Pérez"
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                               required autofocus>
                    </div>
                </div>
 
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               class="form-control"
                               placeholder="usuario@empresa.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required>
                    </div>
                </div>
 
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control"
                               placeholder="Mínimo 6 caracteres"
                               required>
                    </div>
                </div>
 
                <div class="mb-4">
                    <label for="confirm" class="form-label">Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="confirm" name="confirm"
                               class="form-control"
                               placeholder="Repite tu contraseña"
                               required>
                    </div>
                </div>
 
                <button type="submit" class="btn dal-btn-primary w-100">
                    <i class="bi bi-person-plus me-2"></i>Crear cuenta
                </button>
 
            </form>
 
            <p class="auth-switch">
                ¿Ya tienes cuenta?
                <a href="index.php?ruta=login">Inicia sesión</a>
            </p>
        </div>
    </div>
 
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>