<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php"); // $pdo
include_once(__DIR__ . "/../important/cors.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["code" => 401, "message" => "請先登入"]);
    exit;
}
$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["code" => 200, "orders" => $orders]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["code" => 500, "message" => "Database error: " . $e->getMessage()]);
}