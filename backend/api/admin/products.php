
<?php
// Debug version of products.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Paths to includes
$pathDb = __DIR__ . "/../../important/db.php";
$pathCors = __DIR__ . "/../../important/cors.php";
$pathAuth = __DIR__ . "/../../important/authStoreowner.php";

// Check if include files exist
if (!file_exists($pathDb) || !file_exists($pathCors) || !file_exists($pathAuth)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Include file not found",
        "pathDbExists" => file_exists($pathDb),
        "pathCorsExists" => file_exists($pathCors),
        "pathAuthExists" => file_exists($pathAuth),
        "debug_dir" => __DIR__
    ]);
    exit;
}

// Include files
include_once($pathDb);
include_once($pathCors);
include_once($pathAuth);

// Verify $pdo
if (!isset($pdo)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "\$pdo not defined"
    ]);
    exit;
}

try {
    // Example: if using created_at, check if that column exists
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "products" => $products
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>
