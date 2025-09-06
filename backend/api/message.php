<?php
header('Content-Type: application/json');
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");




// Get JSON POST body
$data = json_decode(file_get_contents("php://input"), true);

// Debug log *after* decoding
// file_put_contents('debug.txt', json_encode($data) . PHP_EOL, FILE_APPEND);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$message = $data['message'] ?? '';

if (!$name || !$email || !$phone || !$message) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $message]);

    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
