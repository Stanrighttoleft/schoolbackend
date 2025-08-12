<?php
// Set header for JSON response
header("Content-Type: application/json");

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Example data - this could come from a database
$items = [
    ["id" => 1, "name" => "Item One"],
    ["id" => 2, "name" => "Item Two"],
];

// Process based on HTTP method
switch ($method) {
    case 'GET':
        // Return all items
        echo json_encode($items);
        break;

    case 'POST':
        // Get POST data
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Normally you'd insert into database here
        // For demo, just return the input with a fake ID
        $newItem = [
            "id" => count($items) + 1,
            "name" => $input['name'] ?? 'Unnamed',
        ];
        
        echo json_encode($newItem);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>