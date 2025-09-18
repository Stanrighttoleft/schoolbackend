<?php
header("Content-Type: application/json");

include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php"); // 🔐 Require store owner login

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["code" => 400, "message" => "Missing product ID"]);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Decode sizes if stored as JSON
    if ($product && isset($product['sizes'])) {
        $product['sizes'] = json_decode($product['sizes'], true);
    }

    if ($product) {
        echo json_encode([
            "code" => 200,
            "message" => "success",
            "data" => $product
        ]);
    } else {
        http_response_code(404);
        echo json_encode(["code" => 404, "message" => "Product not found"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "code" => 500,
        "message" => "Internal server error",
        "error" => $e->getMessage()
    ]);
}
?>
