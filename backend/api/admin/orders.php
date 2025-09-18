<?php
include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'orders' => $orders]);
