<?php
// ============================================================
//  DataAuditLabs – Model: Tarea
// ============================================================
 
require_once __DIR__ . '/../libs/Database.php';
 
class TareaModel {
    private PDO $db;
 
    // Estados válidos (sin restricción de flujo entre ellos)
    public const ESTADOS = [
        'pendiente'   => 'Pendiente',
        'en_progreso' => 'En progreso',
        'completada'  => 'Completada',
        'cancelada'   => 'Cancelada',
    ];
 
    public function __construct() {
        $this->db = Database::getConnection();
    }
 
    // Todas las tareas de un usuario
    public function getAllByUser(int $usuarioId): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM tareas WHERE usuario_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }
 
    // Una tarea específica (verificando que pertenezca al usuario)
    public function getById(int $id, int $usuarioId): ?array {
        $stmt = $this->db->prepare(
            'SELECT * FROM tareas WHERE id = ? AND usuario_id = ? LIMIT 1'
        );
        $stmt->execute([$id, $usuarioId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
 
    // Crear tarea
    public function create(int $usuarioId, string $titulo, string $descripcion, string $estado, ?string $fechaLimite): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO tareas (usuario_id, titulo, descripcion, estado, fecha_limite)
             VALUES (?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $usuarioId,
            $titulo,
            $descripcion,
            $estado,
            $fechaLimite ?: null,
        ]);
    }
 
    // Actualizar tarea completa
    public function update(int $id, int $usuarioId, string $titulo, string $descripcion, string $estado, ?string $fechaLimite): bool {
        $stmt = $this->db->prepare(
            'UPDATE tareas
             SET titulo = ?, descripcion = ?, estado = ?, fecha_limite = ?
             WHERE id = ? AND usuario_id = ?'
        );
        return $stmt->execute([
            $titulo,
            $descripcion,
            $estado,
            $fechaLimite ?: null,
            $id,
            $usuarioId,
        ]);
    }
 
    // Cambiar solo el estado (usado por AJAX)
    public function updateEstado(int $id, int $usuarioId, string $estado): bool {
        if (!array_key_exists($estado, self::ESTADOS)) {
            return false;
        }
        $stmt = $this->db->prepare(
            'UPDATE tareas SET estado = ? WHERE id = ? AND usuario_id = ?'
        );
        return $stmt->execute([$estado, $id, $usuarioId]);
    }
 
    // Eliminar tarea
    public function delete(int $id, int $usuarioId): bool {
        $stmt = $this->db->prepare(
            'DELETE FROM tareas WHERE id = ? AND usuario_id = ?'
        );
        return $stmt->execute([$id, $usuarioId]);
    }
}