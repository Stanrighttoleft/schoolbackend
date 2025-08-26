<?php
header('Content-Type: application/json');
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$phone = $data['phone'] ?? '';
$address = $data['address'] ?? '';

if (!$name || !$email || !$password || !$phone || !$address) {
    echo json_encode(["success" => false, "message" => "請填寫所有欄位"]);
    exit;
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Prepare statement with PDO
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword, $phone, $address]);

    echo json_encode(["success" => true, "message" => "註冊成功"]);
} catch (PDOException $e) {
    // You can check for duplicate email by error code if you want
    echo json_encode(["success" => false, "message" => "註冊失敗或帳號已存在"]);
}
?>
