<?php
// ============================================================
//  DataAuditLabs – Model: Usuario
// ============================================================
 
require_once __DIR__ . '/../libs/Database.php';
 
class UsuarioModel {
    private PDO $db;
 
    public function __construct() {
        $this->db = Database::getConnection();
    }
 
    // Buscar usuario por email (para login)
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare(
            'SELECT id, nombre, email, password FROM usuarios WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
 
    // Verificar si el email ya existe (para registro)
    public function emailExists(string $email): bool {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM usuarios WHERE email = ?'
        );
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }
 
    // Crear nuevo usuario
    public function create(string $nombre, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            'INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)'
        );
        return $stmt->execute([$nombre, $email, $hash]);
    }
 
    // Verificar credenciales y retornar el usuario si son correctas
    public function authenticate(string $email, string $password): ?array {
        $usuario = $this->findByEmail($email);
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return null;
    }
}