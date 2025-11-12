<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origins: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "../db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? "";

if($id){
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_params("i", $id);

    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Property deleted successfully"]);
    }else{
        echo json_encode(["success" => false, "message" => "Error deleting property: ". $stmt->error]);
    }

    $stmt->close();
}else{
    echo json_encode(["success" => false, "message" => "Property ID is required"]);
}

$conn->close();

?>