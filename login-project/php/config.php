<?php
// =============================================
// config.php — Configuración de la base de datos
// =============================================
// IMPORTANTE: No subas este archivo con credenciales
// reales a un repositorio público. Usa variables de
// entorno o un archivo .env en producción.
// =============================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'login_db');
define('DB_USER', 'root');       // Cambia en producción
define('DB_PASS', '');           // Cambia en producción
define('DB_CHARSET', 'utf8mb4');

/**
 * Crea y devuelve una conexión PDO a la base de datos.
 * Lanza una excepción si la conexión falla.
 *
 * @return PDO
 */
function getConexion(): PDO {
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Lanza excepciones en error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Devuelve arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                   // Prepared statements reales
    ];

    try {
        return new PDO($dsn, DB_USER, DB_PASS, $opciones);
    } catch (PDOException $e) {
        // En producción, nunca muestres el error al usuario
        error_log('Error de conexión: ' . $e->getMessage());
        die('No se pudo conectar a la base de datos. Revisa la configuración.');
    }
}
