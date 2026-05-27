-- ============================================================
--  DataAuditLabs – Script de base de datos
--  Sistema Web de Gestión de Tareas
-- ============================================================
 
CREATE DATABASE IF NOT EXISTS Tareas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE Tareas;
 
-- ------------------------------------------------------------
--  Tabla: usuarios
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    nombre       VARCHAR(100)    NOT NULL,
    email        VARCHAR(150)    NOT NULL UNIQUE,
    password     VARCHAR(255)    NOT NULL,          -- password_hash()
    created_at   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                         ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
-- ------------------------------------------------------------
--  Tabla: tareas
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tareas (
    id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    usuario_id    INT UNSIGNED    NOT NULL,
    titulo        VARCHAR(200)    NOT NULL,
    descripcion   TEXT,
    estado        ENUM(
                    'pendiente',
                    'en_progreso',
                    'completada',
                    'cancelada'
                  )               NOT NULL DEFAULT 'pendiente',
    fecha_limite  DATE,                             -- NULL = sin límite indicado
    created_at    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                           ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_tareas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
-- ------------------------------------------------------------
--  Datos de prueba
-- ------------------------------------------------------------
 
-- Usuarios (passwords hasheadas con password_hash($pass, PASSWORD_BCRYPT))
-- Usuario 1 → password: Admin123
-- Usuario 2 → password: User456
INSERT INTO usuarios (nombre, email, password) VALUES
(
    'Admin DataAudit',
    'admin@dataauditlabs.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
),
(
    'María López',
    'maria@dataauditlabs.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);
 
-- Tareas de prueba (varían en estado para ver el AJAX en acción)
INSERT INTO tareas (usuario_id, titulo, descripcion, estado, fecha_limite) VALUES
(1, 'Revisar reportes Q2',      'Analizar los reportes del segundo trimestre.',         'pendiente',    '2026-06-10'),
(1, 'Reunión con cliente',      'Preparar presentación para DataAudit Labs S.A.',       'en_progreso',  '2026-05-30'),
(1, 'Actualizar documentación', 'Documentar los nuevos endpoints de la API interna.',   'completada',   '2026-05-20'),
(1, 'Migración de servidor',    'Migrar servicios al nuevo VPS contratado.',            'cancelada',    '2026-06-01'),
(2, 'Capacitación PHP',         'Completar el módulo de MVC nativo del curso.',        'pendiente',    '2026-06-15'),
(2, 'Diseño de formularios',    'Crear wireframes para el módulo de registro.',         'en_progreso',  '2026-05-28');