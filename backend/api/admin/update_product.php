<?php
include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

header("Content-Type: application/json");

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

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

// Build update query
$updateFields = "title = ?, price = ?, description = ?, sizes = ?";
$params = [$title, $price, $description, $sizes];

if ($imagePath) {
    $updateFields .= ", image = ?";
    $params[] = $imagePath;
}

$params[] = $id; // WHERE condition

$sql = "UPDATE products SET $updateFields WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(['success' => true, 'message' => 'Product updated']);
