<?php

require "../../config/MySQLConnector.php";
$db = new MySQLConnector();
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 86400"); // Cache for 1 day
    exit(0);
}

// Set CORS headers for actual request
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Ensure the response is JSON
header("Content-Type: application/json");
$body = file_get_contents('php://input');
$send = json_decode($body);

$email = $send->email;
$password = $send->password;
$rememberPassword = $send->rememberPassword;

$message = new stdClass();

$sql = "SELECT * FROM manifacturer WHERE email = ?  AND password = ?";
$result = $db->search($sql, 'ss', [$email, $password]);


if ($result && count($result) > 0) {
    $userDetails = $result[0];


    session_start();
    $_SESSION["rb_manu"] = $userDetails;

    if ($rememberPassword == "true") {

        setcookie("email_manu", $email, time() + (60 * 60 * 24 * 15));
        setcookie("password_manu", $password, time() + (60 * 60 * 24 * 15));
    }
    $message->type = "success";
    $message->message = "correct username and password";
    $message->user_type = 'manufacturer';
    echo json_encode($message);
} else {

    $message->type = "error";
    $message->message = "Incorrect username or password";
    echo json_encode($message);
}
