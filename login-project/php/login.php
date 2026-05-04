<?php
// =============================================
// login.php — Procesa el formulario de acceso
// =============================================

// Iniciamos sesión antes de cualquier output
session_start();

// Solo aceptamos peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

require_once 'config.php';

// --- 1. Recoger y sanear los datos del formulario ---
$usuario  = trim($_POST['usuario']  ?? '');
$password = trim($_POST['password'] ?? '');

// --- 2. Validar que no estén vacíos ---
if (empty($usuario) || empty($password)) {
    header('Location: ../index.php?error=empty');
    exit;
}

// --- 3. Consulta preparada: evita inyección SQL ---
try {
    $pdo  = getConexion();

    $sql  = 'SELECT id, usuario, password_hash, activo
             FROM usuarios
             WHERE usuario = :usuario
             LIMIT 1';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $fila = $stmt->fetch();

} catch (PDOException $e) {
    error_log('Error en login.php: ' . $e->getMessage());
    header('Location: ../index.php?error=invalid');
    exit;
}

// --- 4. Verificar que el usuario existe ---
if (!$fila) {
    // No revelamos si el usuario existe o no (seguridad)
    header('Location: ../index.php?error=invalid');
    exit;
}

// --- 5. Verificar la contraseña con password_verify ---
if (!password_verify($password, $fila['password_hash'])) {
    header('Location: ../index.php?error=invalid');
    exit;
}

// --- 6. Comprobar si la cuenta está activa ---
if ((int)$fila['activo'] !== 1) {
    header('Location: ../index.php?error=inactive');
    exit;
}

// --- 7. Regenerar el ID de sesión (previene session fixation) ---
session_regenerate_id(true);

// --- 8. Guardar datos en sesión ---
$_SESSION['usuario_id'] = $fila['id'];
$_SESSION['usuario']    = $fila['usuario'];
$_SESSION['login_time'] = time();

// --- 9. Redirigir al dashboard (créalo cuando lo necesites) ---
header('Location: ../dashboard.php');
exit;
