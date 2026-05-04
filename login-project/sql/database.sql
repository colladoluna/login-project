-- =============================================
-- database.sql
-- Base de datos para el proyecto de Login
-- Motor: MySQL / MariaDB
-- =============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS login_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE login_db;

-- =============================================
-- TABLA: usuarios
-- =============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    usuario       VARCHAR(50)     NOT NULL,
    password_hash VARCHAR(255)    NOT NULL,   -- Almacenamos el hash, nunca texto plano
    email         VARCHAR(100)    NOT NULL,
    activo        TINYINT(1)      NOT NULL DEFAULT 1,  -- 1 = activo, 0 = desactivado
    creado_en     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME                 DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_usuario (usuario),
    UNIQUE KEY uq_email   (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- DATOS DE PRUEBA
-- =============================================
-- Las contraseñas se generan con PHP: password_hash('texto', PASSWORD_BCRYPT)
-- Contraseña del usuario 'admin'  → admin123
-- Contraseña del usuario 'prueba' → prueba456

INSERT INTO usuarios (usuario, password_hash, email, activo) VALUES
(
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- admin123
    'admin@ejemplo.com',
    1
),
(
    'prueba',
    '$2y$10$TKh8H1.PfBQLF/RqL.gM.eXBqO4.KPH3Rt9bOuPW.t.2y.5fBCyGS',  -- prueba456
    'prueba@ejemplo.com',
    1
),
(
    'inactivo',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- admin123
    'inactivo@ejemplo.com',
    0   -- Este usuario está desactivado
);

-- =============================================
-- TABLA: sesiones_log (opcional, buena práctica)
-- Registra los intentos de acceso al sistema
-- =============================================
CREATE TABLE IF NOT EXISTS sesiones_log (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id   INT UNSIGNED          DEFAULT NULL,  -- NULL si el usuario no existe
    ip           VARCHAR(45)  NOT NULL,               -- Compatible con IPv6
    exitoso      TINYINT(1)   NOT NULL DEFAULT 0,     -- 1 = éxito, 0 = fallo
    creado_en    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_usuario_id (usuario_id),
    CONSTRAINT fk_log_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- NOTAS PARA EL DESARROLLADOR
-- =============================================
-- Para generar un hash de contraseña en PHP:
--   echo password_hash('tu_contraseña', PASSWORD_BCRYPT);
--
-- Para verificar en PHP:
--   password_verify('tu_contraseña', $hash_de_la_bbdd);
--
-- Importar este archivo:
--   mysql -u root -p < sql/database.sql
-- =============================================
