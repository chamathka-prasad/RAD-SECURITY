<?php
session_start();
require "../../../../config/MySQLConnector.php";


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


    $orderId = $_POST["orderId"];
    $status = $_POST["status"];

    $message = new stdClass();

    if (empty($orderId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if (empty($status)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if ($status != "cancel" && $status != "complete") {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else {

        $statusChangeStatus = "";
        if ($status == "cancel") {
            $statusChangeStatus = "CANCELED";
        } else if ($status == "complete") {
            $statusChangeStatus = "COMPLETED";
        }

        // 
        try {

            $db->beginTransaction();

            $orderResult = $db->search("SELECT * FROM `order` WHERE `id`=?", "i", [$orderId]);
            if (count($orderResult) == 1) {

                $orderManuResult = $db->search("SELECT * FROM `order_has_manifacturer` WHERE `order_id`=?", "i", [$orderId]);
                if (count($orderManuResult) > 0) {
                    for ($o = 0; $o < count($orderManuResult); $o++) {
                        $orderMenu = $orderManuResult[$o];
                        if ($orderMenu["status"] == "PROCESSING") {
                            if ($statusChangeStatus == "COMPLETED") {
                                $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", ["COMPLETED", $orderMenu["id"]]);
                            }
                        }
                    }
                    $db->iud("UPDATE `order` SET `status`=? ,`note`=? WHERE `id`=?", "ssi", [$statusChangeStatus, "Order Is " . $statusChangeStatus, $orderId]);
                    $message->type = "success";
                    $message->message = "Status Changed Success";
                    echo json_encode($message);
                }
            } else {

                $message->type = "error";
                $message->message = "Invalid Request";
                echo json_encode($message);
            }



            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            $message->type = "error";
            $message->message = "Processing error Try Again";
            echo json_encode($message);
        }
        // 

    }
}
