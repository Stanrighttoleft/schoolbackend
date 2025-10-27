<?php
// debugging flags
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");
require_once __DIR__ . '/../../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../important');
$dotenv->load();

header("Content-Type: application/json");

// get product ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}
// Get POST data
$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$sizes = $_POST['sizes'] ?? '';

// validate requried fields
if (!$title || !$price) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Title and price are required']);
    exit;
}

// fetch existing product to get old image
$existingProductStmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
$existingProductStmt->execute([$id]);
$existingProduct = $existingProductStmt->fetch();
$oldImagePath = $existingProduct['image'] ?? null;

// Handle image upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Frontend public folder
    $frontendPublicPath = $_ENV['FRONTEND_PUBLIC_PATH'];
    $uploadDir = rtrim($frontendPublicPath, "/\\") . "/products/small/";

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
            exit;
        }
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $imageName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        // path relative to the public folder
        $imagePath = "/products/small/" . $imageName;
        // remove old image if exists
        if ($oldImagePath && file_exists($frontendPublicPath . $oldImagePath)) {
            unlink($frontendPublicPath . $oldImagePath);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Image upload failed']);
        exit;
    }
}

// Parse sizes (expecting JSON from frontend)
$sizesArray = [];
if (!empty($sizes)) {
    $decoded = json_decode($sizes, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $sizesArray = $decoded;
    } else {
        // If JSON parse failed, also try comma-separated fallback
        $sizesArray = array_filter(array_map('trim', explode(',', $sizes)));
    }
}

try {
    // Update products table
    $updateFields = "title = ?, price = ?, description = ?";
    $params = [$title, $price, $description];

    if ($imagePath) {
        $updateFields .= ", image = ?";
        $params[] = $imagePath;
    }

    $params[] = $id; // WHERE condition

    $sql = "UPDATE products SET $updateFields WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed preparing update statement");
    }
    $stmt->execute($params);

    // Update product_sizes table
    // First delete existing
    $deleteSizesStmt = $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?");
    if (!$deleteSizesStmt) {
        throw new Exception("Failed preparing delete statement for product_sizes");
    }
    $deleteSizesStmt->execute([$id]);

    // Insert new sizes
    if (!empty($sizesArray)) {
        $insertSizeStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size) VALUES (?, ?)");
        if (!$insertSizeStmt) {
            throw new Exception("Failed preparing insert statement for product_sizes");
        }
        foreach ($sizesArray as $size) {
            // you may want to validate $size (length, allowed chars) before inserting
            $insertSizeStmt->execute([$id, $size]);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product updated',
        'product' => [
            'id' => $id,
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'image' => $imagePath ?? $oldImagePath
        ]

    ]);
} catch (Exception $e) {
    http_response_code(500);
    // for debugging, include exception message
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
