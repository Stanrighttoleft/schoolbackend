<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");


try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();

    echo json_encode([
        "code" => 200,
        "message" => "success",
        "data" => $products
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "code" => 500,
        "message" => "Internal server error",
        "error" => $e->getMessage()
    ]);
}
?>
