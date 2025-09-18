<?php
include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

$data = json_decode(file_get_contents("php://input"));
$id = $data->id ?? null;
$name = $data->name ?? '';
$price = $data->price ?? 0;
$description = $data->description ?? '';

if (!$id || !$name || !$price) {
    echo json_encode(['success' => false, 'message' => 'ID, name and price required']);
    exit;
}

$stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
$stmt->execute([$name, $price, $description, $id]);

echo json_encode(['success' => true, 'message' => 'Product updated']);
