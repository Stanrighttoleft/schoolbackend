<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(["code" => 400, "message" => "Invalid product ID"]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo json_encode([
            "code" => 200,
            "message" => "success",
            "data" => $product
        ]);
    } else {
        echo json_encode([
            "code" => 404,
            "message" => "product not found"
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
