<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión – DataAuditLabs</title>
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
            <p class="auth-tagline">Gestiona tus tareas con claridad,<br>control y sin papel.</p>
            <ul class="auth-features">
                <li><i class="bi bi-check2-circle"></i> CRUD completo de tareas</li>
                <li><i class="bi bi-check2-circle"></i> Cambio de estado en tiempo real</li>
                <li><i class="bi bi-check2-circle"></i> Solo ves tus propias tareas</li>
            </ul>
        </div>
    </div>
 
    <!-- Panel derecho – formulario -->
    <div class="auth-panel-right">
        <div class="auth-form-box">
 
            <h2 class="auth-title">Bienvenido de vuelta</h2>
            <p class="auth-subtitle">Ingresa tus credenciales para continuar</p>
 
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
 
            <?php if (!empty($success)): ?>
                <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
 
            <form method="POST" action="index.php?ruta=login" novalidate>
 
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               class="form-control"
                               placeholder="usuario@empresa.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required autofocus>
                    </div>
                </div>
 
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                    </div>
                </div>
 
                <button type="submit" class="btn dal-btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                </button>
 
            </form>
 
            <p class="auth-switch">
                ¿No tienes cuenta?
                <a href="index.php?ruta=registro">Regístrate aquí</a>
            </p>
        </div>
    </div>
 
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 