<?php
header('Content-Type: application/json');
include('../important/db.php');
include_once(__DIR__ . "/../important/cors.php");

// ✅ Set session cookie params once, before session_start()
session_set_cookie_params([
    'lifetime' => 0,       // session ends when browser closes
    'path' => '/',
    'domain' => '',        // leave blank = current domain
    'secure' => false,     // change to true when using HTTPS
    'httponly' => true,
    'samesite' => 'Lax'    // use 'None' if frontend runs on different domain (must also set 'secure' => true)
]);

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['user' => null]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, name, email, phone, address FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['user' => $user ?: null]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
