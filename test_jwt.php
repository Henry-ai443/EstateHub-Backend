<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

$payload = ["user_id" => 1];
$jwt = JWT::encode($payload, "TestSecretKey", 'HS256');
echo $jwt;
?>
