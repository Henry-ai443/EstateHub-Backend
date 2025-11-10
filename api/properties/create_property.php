<?php
header("Content-Type: application/json");            
header("Access-Control-Allow-Origin: *");             
header("Access-Control-Allow-Methods: POST");         
header("Access-Control-Allow-Headers: Content-Type"); 

include "../db.php"; 

try {
    $data = json_decode(file_get_contents("php://input"), true);

    $title = $data['title'] ?? '';
    $location = $data['location'] ?? '';
    $price = $data['price'] ?? '';
    $type = $data['type'] ?? '';
    $description = $data['description'] ?? '';
    $image = $data['image'] ?? '';

    if (!$title || !$location || !$price || !$type) {
        throw new Exception("Missing required fields: title, location, price, or type");
    }

    $stmt = $conn->prepare(
        "INSERT INTO properties (title, location, price, type, description, image) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("ssdsss", $title, $location, $price, $type, $description, $image);

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode([
        "success" => true,
        "message" => "Property created successfully"
    ]);

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
