<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php");
include_once(__DIR__ . "/../important/cors.php");

try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "code" => 200,
        "message" => "success",
        "data" => $products
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
