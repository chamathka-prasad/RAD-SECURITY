<?php
session_start();
require "../../../config/MySQLConnector.php";


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

$db = new MySQLConnector();

if (isset($_SESSION["rb_user"])) {


//     $sessionAdmin = $_SESSION["rb_admin"];

$message = new stdClass();

$sql = "SELECT `id`,`name`,`img`,`username`,`email`,`password` FROM `user` WHERE `type`='designer'";
$result = $db->search($sql);
echo json_encode($result);



    // $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");


    // if ($resultsUser->num_rows == 0) {



    // } else {
    //     $message->type = "error";
    //     $message->message = "Invalid Email";
    //     echo json_encode($message);
    // }

}
