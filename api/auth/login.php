<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include "../../db.php"; // your database connection

require_once "../../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Secret key for JWT
$secretKey = "9vK!7pL2x@Fz#Qw8rYd&Nm4sTj6UbXcE";

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['email']) || empty($data['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required."
    ]);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];

$stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password."
    ]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password."
    ]);
    exit;
}

// Generate JWT token
$payload = [
    "user_id" => $user['id'],
    "email" => $user['email'],
    "role" => $user['role'],
    "iat" => time(),
    "exp" => time() + 3600 // token valid for 1 hour
];

$jwt = JWT::encode($payload, $secretKey, 'HS256');

echo json_encode([
    "success" => true,
    "message" => "Login successful.",
    "token" => $jwt,
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "role" => $user['role']
    ]
]);

$stmt->close();
$conn->close();
?>
