<?php
// ============================================================
//  DataAuditLabs – Controller: Tareas (CRUD + AJAX)
// ============================================================
 
require_once __DIR__ . '/../models/TareaModel.php';
require_once __DIR__ . '/../libs/Session.php';
 
class TareaController {
    private TareaModel $model;
    private int $usuarioId;
 
    public function __construct() {
        require_login();
        $this->model    = new TareaModel();
        $this->usuarioId = (int) session_get('usuario_id');
    }
 
    // GET /tareas – listar todas las tareas del usuario
    public function index(): void {
        $tareas  = $this->model->getAllByUser($this->usuarioId);
        $estados = TareaModel::ESTADOS;
        $success = flash_get('success');
        $error   = flash_get('error');
        require_once __DIR__ . '/../views/tareas/index.php';
    }
 
    // GET /tareas/crear – formulario de creación
    public function crear(): void {
        $estados = TareaModel::ESTADOS;
        $error   = flash_get('error');
        require_once __DIR__ . '/../views/tareas/crear.php';
    }
 
    // POST /tareas/guardar – guardar nueva tarea
    public function guardar(): void {
        $titulo      = trim($_POST['titulo']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado      = trim($_POST['estado']      ?? 'pendiente');
        $fechaLimite = trim($_POST['fecha_limite']?? '');
 
        if (empty($titulo)) {
            flash_set('error', 'El título es obligatorio.');
            redirect('index.php?ruta=tareas/crear');
        }
 
        if (!array_key_exists($estado, TareaModel::ESTADOS)) {
            $estado = 'pendiente';
        }
 
        $ok = $this->model->create(
            $this->usuarioId,
            $titulo,
            $descripcion,
            $estado,
            $fechaLimite ?: null
        );
 
        if ($ok) {
            flash_set('success', 'Tarea creada correctamente.');
        } else {
            flash_set('error', 'No se pudo crear la tarea.');
        }
 
        redirect('index.php?ruta=tareas');
    }
 
    // GET /tareas/editar?id=X – formulario de edición
    public function editar(): void {
        $id    = (int) ($_GET['id'] ?? 0);
        $tarea = $this->model->getById($id, $this->usuarioId);
 
        if (!$tarea) {
            flash_set('error', 'Tarea no encontrada.');
            redirect('index.php?ruta=tareas');
        }
 
        $estados = TareaModel::ESTADOS;
        $error   = flash_get('error');
        require_once __DIR__ . '/../views/tareas/editar.php';
    }
 
    // POST /tareas/actualizar – guardar cambios en tarea existente
    public function actualizar(): void {
        $id          = (int)   ($_POST['id']          ?? 0);
        $titulo      = trim($_POST['titulo']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado      = trim($_POST['estado']      ?? 'pendiente');
        $fechaLimite = trim($_POST['fecha_limite']?? '');
 
        if (empty($titulo)) {
            flash_set('error', 'El título es obligatorio.');
            redirect("index.php?ruta=tareas/editar&id=$id");
        }
 
        if (!array_key_exists($estado, TareaModel::ESTADOS)) {
            $estado = 'pendiente';
        }
 
        $ok = $this->model->update(
            $id,
            $this->usuarioId,
            $titulo,
            $descripcion,
            $estado,
            $fechaLimite ?: null
        );
 
        if ($ok) {
            flash_set('success', 'Tarea actualizada correctamente.');
        } else {
            flash_set('error', 'No se pudo actualizar la tarea.');
        }
 
        redirect('index.php?ruta=tareas');
    }
 
    // POST /tareas/eliminar – eliminar tarea
    public function eliminar(): void {
        $id = (int) ($_POST['id'] ?? 0);
        $ok = $this->model->delete($id, $this->usuarioId);
 
        if ($ok) {
            flash_set('success', 'Tarea eliminada.');
        } else {
            flash_set('error', 'No se pudo eliminar la tarea.');
        }
 
        redirect('index.php?ruta=tareas');
    }
 
    // POST /tareas/cambiar-estado  (AJAX – responde JSON)
    public function cambiarEstado(): void {
        header('Content-Type: application/json');
 
        // Solo aceptar peticiones AJAX
        if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
            http_response_code(403);
            echo json_encode(['ok' => false, 'mensaje' => 'Acceso no permitido.']);
            exit;
        }
 
        $data   = json_decode(file_get_contents('php://input'), true);
        $id     = (int)    ($data['id']     ?? 0);
        $estado = trim((string) ($data['estado'] ?? ''));
 
        if (!$id || !array_key_exists($estado, TareaModel::ESTADOS)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'mensaje' => 'Datos inválidos.']);
            exit;
        }
 
        $ok = $this->model->updateEstado($id, $this->usuarioId, $estado);
 
        echo json_encode([
            'ok'            => $ok,
            'mensaje'       => $ok ? 'Estado actualizado.' : 'No se pudo actualizar.',
            'estado'        => $estado,
            'estadoLabel'   => TareaModel::ESTADOS[$estado],
        ]);
        exit;
    }
}