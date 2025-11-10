<?php
include "db.php"; // includes our database connection
echo json_encode(["success" => true, "message" => "Database connected successfully"]);
?>
