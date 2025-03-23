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


    $session = $_SESSION["rb_user"];


    $opassword = $_POST["opassword"];
    $npassword = $_POST["npassword"];



    $regex = '/^\+?\d+$/';
    $message = new stdClass();

    if (empty($opassword)) {
        $message->type = "error";
        $message->message = "Old Password Is Empty";
        echo json_encode($message);
    } else if (empty($npassword)) {
        $message->type = "error";
        $message->message = "New Password Is Empty";
        echo json_encode($message);
    } else {

        $userResult = $db->search("SELECT * FROM `user` WHERE `id`=?", 'i', [$session["id"]]);
        if (count($userResult) == 1) {
            $sql = "SELECT * FROM user WHERE id=? AND `password`=?";
            $result = $db->search($sql, 'is', [$session["id"], $opassword]);


            if (count($result) == 1) {
                $savePath = "";


                $insertManifacturer = $db->iud("UPDATE `user` SET `password`=? WHERE `id`=?
                    ", "si", [$npassword, $session["id"]]);

                if ($insertManifacturer['affected_rows'] > 0) {


                    $message->type = "success";
                    $message->message = "User Password Update Success";
                    echo json_encode($message);
                } else {
                    $message->type = "error";
                    $message->message = "Same Password. Password not Changed";
                    echo json_encode($message);
                }
            } else {
                $message->type = "error";
                $message->message = "Please Add The Old Password Correctly";
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid Request";
            echo json_encode($message);
        }
    }
}
