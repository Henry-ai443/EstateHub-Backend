<?php
$host = "localhost";
$user = "root";
$password = "Hm@0724356198";
$dbname = "REMS";

try {
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
} catch (Exception $e) {
    die(json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]));
}
?>
