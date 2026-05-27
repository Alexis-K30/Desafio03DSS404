<?php
// ============================================================
//  DataAuditLabs – Clase Database (Singleton PDO)
// ============================================================
 
require_once __DIR__ . '/../config/database.php';
 
class Database {
    private static ?PDO $instance = null;
 
    // Impedir instanciación directa
    private function __construct() {}
 
    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST
                 . ';dbname='   . DB_NAME
                 . ';charset='  . DB_CHARSET;
 
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
 
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // En producción nunca mostrar el mensaje real
                die(json_encode([
                    'error' => 'Error de conexión a la base de datos.'
                ]));
            }
        }
 
        return self::$instance;
    }
}