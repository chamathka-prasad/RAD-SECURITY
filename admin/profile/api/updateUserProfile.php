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


    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];




    $regex = '/^\+?\d+$/';
    $message = new stdClass();

    if (empty($name)) {
        $message->type = "error";
        $message->message = "Profile Name Is Empty";
        echo json_encode($message);
    } else if (empty($username)) {
        $message->type = "error";
        $message->message = "Username Is Empty";
        echo json_encode($message);
    } else if (empty($email)) {
        $message->type = "error";
        $message->message = "User Email Is Empty";
        echo json_encode($message);
    } else {

        $userResult = $db->search("SELECT * FROM `user` WHERE `id`=?", 'i', [$session["id"]]);
        if (count($userResult) == 1) {
            $sql = "SELECT * FROM user WHERE (name = ?  OR email = ? OR username=?) AND id!=?";
            $result = $db->search($sql, 'sssi', [$name, $email, $username, $session["id"]]);


            if (count($result) == 0) {
                $savePath = "";
                if (isset($_FILES["image"])) {



                    $img = $_FILES["image"];


                    $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                    $img["type"];
                    $fileName = uniqid();
                    $savePath = $fileName . "." . $ext;
                    $path = "../../../resources/userImg/" . $fileName . "." . $ext;
                    move_uploaded_file($img["tmp_name"], $path);

                    $insertManifacturer = $db->iud("UPDATE `user` SET `name`=?,`username`=?,`img`=?,`email`=? WHERE `id`=?
                ", "ssssi", [$name, $username, $savePath, $email, $session["id"]]);

                    if ($insertManifacturer['affected_rows'] > 0) {


                        $sql = "SELECT * FROM user WHERE id = ?";
                        $result = $db->search($sql, 'i', [$session["id"]]);


                        if ($result && count($result) > 0) {
                            $userDetails = $result[0];


                            $_SESSION["rb_user"] = $userDetails;
                        }
                        $message->type = "success";
                        $message->message = "User Profile Update Success";
                        echo json_encode($message);
                    } else {
                        $message->type = "error";
                        $message->message = "You have to change the details before update";
                        echo json_encode($message);
                    }
                } else {

                    $insertManifacturer = $db->iud("UPDATE `user` SET `name`=?,`username`=?,`email`=? WHERE `id`=?
                    ", "sssi", [$name, $username, $email, $session["id"]]);

                    if ($insertManifacturer['affected_rows'] > 0) {



                        $sql = "SELECT * FROM user WHERE id = ?";
                        $result = $db->search($sql, 'i', [$session["id"]]);


                        if ($result && count($result) > 0) {
                            $userDetails = $result[0];


                            $_SESSION["rb_user"] = $userDetails;
                        }
                        $message->type = "success";
                        $message->message = "User Profile Update Success";
                        echo json_encode($message);
                    } else {
                        $message->type = "error";
                        $message->message = "You have to change the details before update";
                        echo json_encode($message);
                    }
                }
            } else {
                $userDetails = $result[0];

                $message->type = "error";

                if ($userDetails["name"] == $name) {
                    $message->message = "Profile Name Is Already Registred.";
                } else if ($userDetails["username"] == $username) {
                    $message->message = "User Name Is Already Registred.";
                } else {
                    $message->message = "Email Is Already Registred.";
                }

                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid Request";
            echo json_encode($message);
        }
    }
}
