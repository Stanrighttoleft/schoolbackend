<?php
header("Content-Type: application/json");
include_once(__DIR__ . "/../important/db.php"); // $pdo
include_once(__DIR__ . "/../important/cors.php");
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$customerName = $data['customerName'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$address = $data['address'] ?? '';
$paymentMethod = $data['paymentMethod'] ?? '';
$shipping = $data['shipping'] ?? '';
$shippingCost = $data['shippingCost'] ?? 0;
$finalPrice = $data['finalPrice'] ?? 0;
$items = $data['items'] ?? [];

// Check login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["code" => 401, "message" => "請先登入"]);
    exit;
}
$userId = $_SESSION['user_id'];

if (!$customerName || !$email || !$phone || !$address || empty($items)) {
    http_response_code(400);
    echo json_encode(["code" => 400, "message" => "Missing required fields"]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Insert order (with user_id)
    $stmt = $pdo->prepare("INSERT INTO orders 
        (user_id, customer_name, email, phone, address, payment_method, shipping, shipping_cost, final_price, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $userId, $customerName, $email, $phone, $address,
        $paymentMethod, $shipping, $shippingCost, $finalPrice
    ]);

    $orderId = $pdo->lastInsertId();

    // Insert items
    $stmtItem = $pdo->prepare("INSERT INTO order_items 
        (order_id, product_id, size, quantity, price) VALUES (?, ?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmtItem->execute([
            $orderId,
            $item['id'],
            $item['size'] ?? '',
            $item['cartQuantity'],
            $item['price']
        ]);
    }

    $pdo->commit();

    echo json_encode([
        "code" => 200,
        "message" => "Order created successfully",
        "order" => [
            "id" => $orderId,
            "customerName" => $customerName,
            "finalPrice" => $finalPrice,
        ]
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["code" => 500, "message" => "Database error: " . $e->getMessage()]);
}
