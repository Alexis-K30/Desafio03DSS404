<?php
// ============================================================
//  DataAuditLabs – Helper de sesión
// ============================================================
 
function session_init(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
 
function is_logged_in(): bool {
    session_init();
    return isset($_SESSION['usuario_id']);
}
 
function require_login(): void {
    if (!is_logged_in()) {
        redirect('index.php?ruta=login');
    }
}
 
function login_user(array $usuario): void {
    session_init();
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_email']  = $usuario['email'];
}
 
function logout_user(): void {
    session_init();
    session_destroy();
}
 
function session_get(string $key): mixed {
    session_init();
    return $_SESSION[$key] ?? null;
}
 
function redirect(string $url): never {
    header("Location: $url");
    exit;
}
 
function flash_set(string $key, string $message): void {
    session_init();
    $_SESSION['flash'][$key] = $message;
}
 
function flash_get(string $key): ?string {
    session_init();
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}