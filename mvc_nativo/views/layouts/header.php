<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'DataAuditLabs') ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link href="<?= BASE_URL ?>public/css/app.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg dal-navbar">
    <div class="container">
        <a class="navbar-brand dal-brand" href="<?= BASE_URL ?>index.php?ruta=tareas">
            <span class="brand-icon"><i class="bi bi-clipboard2-check-fill"></i></span>
            DataAudit<span class="brand-accent">Labs</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php?ruta=tareas">
                        <i class="bi bi-list-task me-1"></i>Mis Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php?ruta=tareas/crear">
                        <i class="bi bi-plus-circle me-1"></i>Nueva Tarea
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <span class="nav-user">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars(session_get('usuario_nombre') ?? '') ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-logout" href="<?= BASE_URL ?>index.php?ruta=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Salir
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="dal-main">
    <div class="container py-4">