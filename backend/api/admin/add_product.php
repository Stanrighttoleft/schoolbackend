<?php
// debugging flags
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__ . "/../../important/db.php");
include_once(__DIR__ . "/../../important/cors.php");
include_once(__DIR__ . "/../../important/authStoreowner.php");

header("Content-Type: application/json");

// Get POST data
$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$sizes = $_POST['sizes'] ?? '';

// Validate required fields
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
        $imagePath = "uploads/" . $imageName;
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
    // Insert into products table
    $sql = "INSERT INTO products (title, price, description, image) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare product insert statement");
    }
    $stmt->execute([$title, $price, $description, $imagePath]);

    $productId = $pdo->lastInsertId();

    // Insert sizes into product_sizes
    if (!empty($sizesArray)) {
        $insertSizeStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size) VALUES (?, ?)");
        if (!$insertSizeStmt) {
            throw new Exception("Failed to prepare product_sizes insert statement");
        }
        foreach ($sizesArray as $size) {
            // Optional: validate $size before inserting
            $insertSizeStmt->execute([$productId, $size]);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product added']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    exit;
}
