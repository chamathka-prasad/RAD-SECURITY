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

if (isset($_SESSION["rb_manu"])) {


    $session = $_SESSION["rb_manu"];


    $name = $_POST["name"];
    $email = $_POST["email"];




    $regex = '/^\+?\d+$/';
    $message = new stdClass();

    if (empty($name)) {
        $message->type = "error";
        $message->message = "Profile Name Is Empty";
        echo json_encode($message);
    } else if (empty($email)) {
        $message->type = "error";
        $message->message = "User Email Is Empty";
        echo json_encode($message);
    } else {

        $userResult = $db->search("SELECT * FROM `manifacturer` WHERE `id`=?", 'i', [$session["id"]]);
        if (count($userResult) == 1) {
            $sql = "SELECT * FROM manifacturer WHERE (name = ?  OR email = ?) AND id!=?";
            $result = $db->search($sql, 'ssi', [$name, $email, $session["id"]]);


            if (count($result) == 0) {
                $savePath = "";
                if (isset($_FILES["image"])) {



                    $img = $_FILES["image"];


                    $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                    $img["type"];
                    $fileName = uniqid();
                    $savePath = $fileName . "." . $ext;
                    $path = "../../../resources/companyImg/" . $fileName . "." . $ext;
                    move_uploaded_file($img["tmp_name"], $path);

                    $insertManifacturer = $db->iud("UPDATE `manifacturer` SET `name`=?,`img`=?,`email`=? WHERE `id`=?
                ", "sssi", [$name, $savePath, $email, $session["id"]]);

                    if ($insertManifacturer['affected_rows'] > 0) {


                        $sql = "SELECT * FROM manifacturer WHERE id = ?";
                        $result = $db->search($sql, 'i', [$session["id"]]);


                        if ($result && count($result) > 0) {
                            $userDetails = $result[0];


                            $_SESSION["rb_manu"] = $userDetails;
                        }
                        $message->type = "success";
                        $message->message = "Your Profile Update Success";
                        echo json_encode($message);
                    } else {
                        $message->type = "error";
                        $message->message = "You have to change the details before update";
                        echo json_encode($message);
                    }
                } else {

                    $insertManifacturer = $db->iud("UPDATE `manifacturer` SET `name`=?,`email`=? WHERE `id`=?
                    ", "ssi", [$name, $email, $session["id"]]);

                    if ($insertManifacturer['affected_rows'] > 0) {



                        $sql = "SELECT * FROM manifacturer WHERE id = ?";
                        $result = $db->search($sql, 'i', [$session["id"]]);


                        if ($result && count($result) > 0) {
                            $userDetails = $result[0];


                            $_SESSION["rb_manu"] = $userDetails;
                        }
                        $message->type = "success";
                        $message->message = "Your Profile Update Success";
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
