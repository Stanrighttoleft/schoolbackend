<?php
session_set_cookie_params([
    'path' => '/',
    'samesite' => 'None',   // <- Required for cross-origin cookies
    'secure' => false,      // <- Must be true in HTTPS, false in localhost
    'httponly' => true,
]);
session_start();
header('Content-Type: application/json');
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");

// Get JSON POST body
$data = json_decode(file_get_contents("php://input"));
$email = $data->email ?? '';
$password = $data->password ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password required']);
    exit;
}


try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'image' => 'user not found']);
        exit;
    }
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'password incorrect',
            'input_password' => $password,
            'stored_hash' => $user['password']
        ]);
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    unset($user['password']);
    echo json_encode(['success' => true, 'user' => $user]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}