<?php
include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

header("Content-Type: application/json");

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$sizes = $_POST['sizes'] ?? '[]';

if (!$title || !$price) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Title and price are required']);
    exit;
}

// Handle image upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . "/../../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $imageName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        $imagePath = "uploads/" . $imageName;
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Image upload failed']);
        exit;
    }
}

$sql = "INSERT INTO products (title, price, description, sizes, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $price, $description, $sizes, $imagePath]);

echo json_encode(['success' => true, 'message' => 'Product added']);
