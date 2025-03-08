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


    $id = $_POST["id"];
    $cname = $_POST["cname"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $caddress = $_POST["caddress"];


    $regex = '/^\+?\d+$/';
    $message = new stdClass();

    if (empty($cname)) {
        $message->type = "error";
        $message->message = "Company Name Is Empty";
        echo json_encode($message);
    } else if (empty($email)) {
        $message->type = "error";
        $message->message = "Company Email Is Empty";
        echo json_encode($message);
    } else if (empty($mobile)) {
        $message->type = "error";
        $message->message = "Company Mobile Is Empty";
        echo json_encode($message);
    } else if (empty($caddress)) {
        $message->type = "error";
        $message->message = "Company Address Is Empty";
        echo json_encode($message);
    } else {

        $userResult = $db->search("SELECT * FROM `manifacturer` WHERE `id`=?", 'i', [$id]);
        if (count($userResult) == 1) {
            $sql = "SELECT * FROM manifacturer WHERE (name = ?  OR email = ?) AND id!=?";
            $result = $db->search($sql, 'ssi', [$cname, $email, $id]);


            if (count($result) == 0) {
                $savePath = "";
                if (isset($_FILES["cimg"])) {



                    $img = $_FILES["cimg"];


                    $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                    $img["type"];
                    $fileName = uniqid();
                    $savePath = $fileName . "." . $ext;
                    $path = "../../../resources/companyImg/" . $fileName . "." . $ext;
                    move_uploaded_file($img["tmp_name"], $path);

                    $insertManifacturer = $db->iud("UPDATE `manifacturer` SET `name`=?,`address`=?,`img`=?,`email`=?,`mobile`=? WHERE `id`=?
                ", "sssssi", [$cname, $caddress, $savePath, $email, $mobile, $id]);

                    if ($insertManifacturer['affected_rows'] > 0) {


                        $message->type = "success";
                        $message->message = "Manufacturer Update Success";
                        echo json_encode($message);
                    } else {
                        $message->type = "error";
                        $message->message = "You have to change the details before update";
                        echo json_encode($message);
                    }
                } else {
                    $insertManifacturer = $db->iud("UPDATE `manifacturer` SET `name`=?,`address`=?,`email`=?,`mobile`=? WHERE `id`=?", "ssssi", [$cname, $caddress, $email, $mobile, $id]);

                    if ($insertManifacturer['affected_rows'] > 0) {


                        $message->type = "success";
                        $message->message = "Manufacturer Update Success";
                        echo json_encode($message);
                    } else {
                        $message->type = "error";
                        $message->message = "You have to change the details before update";
                        echo json_encode($message);
                    }
                }
            } else {
                $manifacurer = $result[0];

                $message->type = "error";

                if ($manifacurer["name"] == $cname) {
                    $message->message = "Company Name Is Already Registred.";
                } else {
                    $message->message = "Company Email Is Already Registred.";
                }

                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid Manufacturer";
            echo json_encode($message);
        }




        // $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");


        // if ($resultsUser->num_rows == 0) {



        // } else {
        //     $message->type = "error";
        //     $message->message = "Invalid Email";
        //     echo json_encode($message);
        // }
    }
}
