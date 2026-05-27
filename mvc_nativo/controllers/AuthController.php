<?php
// ============================================================
//  DataAuditLabs – Controller: Auth (registro y login)
// ============================================================
 
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../libs/Session.php';
 
class AuthController {
    private UsuarioModel $model;
 
    public function __construct() {
        $this->model = new UsuarioModel();
    }
 
    // GET /login
    public function showLogin(): void {
        if (is_logged_in()) {
            redirect('index.php?ruta=tareas');
        }
        $error   = flash_get('error');
        $success = flash_get('success');
        require_once __DIR__ . '/../views/auth/login.php';
    }
 
    // POST /login
    public function login(): void {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
 
        // Validación básica
        if (empty($email) || empty($password)) {
            flash_set('error', 'Todos los campos son obligatorios.');
            redirect('index.php?ruta=login');
        }
 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash_set('error', 'El correo no tiene un formato válido.');
            redirect('index.php?ruta=login');
        }
 
        $usuario = $this->model->authenticate($email, $password);
 
        if (!$usuario) {
            flash_set('error', 'Correo o contraseña incorrectos.');
            redirect('index.php?ruta=login');
        }
 
        login_user($usuario);
        redirect('index.php?ruta=tareas');
    }
 
    // GET /registro
    public function showRegistro(): void {
        if (is_logged_in()) {
            redirect('index.php?ruta=tareas');
        }
        $error   = flash_get('error');
        $success = flash_get('success');
        require_once __DIR__ . '/../views/auth/registro.php';
    }
 
    // POST /registro
    public function registro(): void {
        $nombre   = trim($_POST['nombre']    ?? '');
        $email    = trim($_POST['email']     ?? '');
        $password = trim($_POST['password']  ?? '');
        $confirm  = trim($_POST['confirm']   ?? '');
 
        // Validaciones
        if (empty($nombre) || empty($email) || empty($password) || empty($confirm)) {
            flash_set('error', 'Todos los campos son obligatorios.');
            redirect('index.php?ruta=registro');
        }
 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash_set('error', 'El correo no tiene un formato válido.');
            redirect('index.php?ruta=registro');
        }
 
        if (strlen($password) < 6) {
            flash_set('error', 'La contraseña debe tener al menos 6 caracteres.');
            redirect('index.php?ruta=registro');
        }
 
        if ($password !== $confirm) {
            flash_set('error', 'Las contraseñas no coinciden.');
            redirect('index.php?ruta=registro');
        }
 
        if ($this->model->emailExists($email)) {
            flash_set('error', 'Ese correo ya está registrado.');
            redirect('index.php?ruta=registro');
        }
 
        if ($this->model->create($nombre, $email, $password)) {
            flash_set('success', '¡Cuenta creada! Ya puedes iniciar sesión.');
            redirect('index.php?ruta=login');
        } else {
            flash_set('error', 'Ocurrió un error al crear la cuenta. Intenta de nuevo.');
            redirect('index.php?ruta=registro');
        }
    }
 
    // GET /logout
    public function logout(): void {
        logout_user();
        flash_set('success', 'Sesión cerrada correctamente.');
        redirect('index.php?ruta=login');
    }
}