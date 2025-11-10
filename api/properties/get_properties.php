<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "../db.php";

$result = $conn->query("SELECT * FROM properties ORDER BY created_at DESC");

$properties = [];

while($row = $result->fetch_assoc()){
    $properties[] = $row;
}

echo json_encode($properties);

$conn->close();
?>
