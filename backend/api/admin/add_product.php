<?php
include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

$data = json_decode(file_get_contents("php://input"));

$name = $data->name ?? '';
$price = $data->price ?? 0;
$description = $data->description ?? '';

if (!$name || !$price) {
    echo json_encode(['success' => false, 'message' => 'Name and price are required']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
$stmt->execute([$name, $price, $description]);

echo json_encode(['success' => true, 'message' => 'Product added']);
