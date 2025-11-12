<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Headers: Content-Type");

    include "../db.php";

    $data = json_decode(file_get_contents("php://input"));

    $id = $data['id'] ?? '';
    $title = $data['title'] ?? "";
    $location = $data['location'] ?? "";
    $price = $data['price'] ?? "";
    $type = $data['type'] ?? "";
    $description = $data["description"] ?? "";
    $image = $data["image"] ?? "";
    $status = $data["status"] ?? 'available';

    if($id && $title && $location && $price && $type){
        $stmt = $conn->prepare("UPDATE properties SET title = ?, location = ?, price = ?, type = ?, description = ?, image = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssdssssi", $title, $location, $price, $type, $description, $image, $status, $id);

        if($stmt->execute()){
            echo json_encode(["success" => true, "message" => "Property updated successfully"]);
        }else{
            echo json_encode(["success" => false, "message" => "Error updating property"]);
        }

        $stmt->close();
    }else{
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
    }

    $conn->close()
?>