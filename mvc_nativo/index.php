<?php
// ============================================================
//  DataAuditLabs – Front Controller (index.php)
// ============================================================
 
require_once __DIR__ . '/libs/Session.php';
session_init();
 
// Leer la ruta desde ?ruta=
$ruta = trim($_GET['ruta'] ?? 'login');
 
// ---- Rutas de autenticación --------------------------------
if ($ruta === 'login') {
    require_once __DIR__ . '/controllers/AuthController.php';
    $ctrl = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ctrl->login();
    } else {
        $ctrl->showLogin();
    }
 
} elseif ($ruta === 'registro') {
    require_once __DIR__ . '/controllers/AuthController.php';
    $ctrl = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ctrl->registro();
    } else {
        $ctrl->showRegistro();
    }
 
} elseif ($ruta === 'logout') {
    require_once __DIR__ . '/controllers/AuthController.php';
    (new AuthController())->logout();
 
// ---- Rutas de tareas ---------------------------------------
} elseif ($ruta === 'tareas') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->index();
 
} elseif ($ruta === 'tareas/crear') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->crear();
 
} elseif ($ruta === 'tareas/guardar') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->guardar();
 
} elseif ($ruta === 'tareas/editar') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->editar();
 
} elseif ($ruta === 'tareas/actualizar') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->actualizar();
 
} elseif ($ruta === 'tareas/eliminar') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->eliminar();
 
} elseif ($ruta === 'tareas/cambiar-estado') {
    require_once __DIR__ . '/controllers/TareaController.php';
    (new TareaController())->cambiarEstado();
 
// ---- 404 ---------------------------------------------------
} else {
    http_response_code(404);
    echo '<h1>404 – Página no encontrada</h1>';
}