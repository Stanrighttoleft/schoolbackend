<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");


if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["code" => 400, "message" => "Missing product ID"]);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        echo json_encode([
            "code" => 200,
            "message" => "success",
            "data" => $product
        ]);
    } else {
        http_response_code(404);
        echo json_encode(["code" => 404, "message" => "product not found"]);
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
