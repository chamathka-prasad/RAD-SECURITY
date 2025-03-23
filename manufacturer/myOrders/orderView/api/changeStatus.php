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

if (isset($_SESSION["rb_manu"])) {


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
    } else {

        $statusChangeStatus = $status;


        // 
        try {

            $db->beginTransaction();


            $orderManuResult = $db->search("SELECT * FROM `order_has_manifacturer` WHERE `id`=?", "i", [$orderId]);
            if (count($orderManuResult) > 0) {
                for ($o = 0; $o < count($orderManuResult); $o++) {
                    $orderMenu = $orderManuResult[$o];
                    if ($orderMenu["status"] != "NOT SUBMITTED" && $orderMenu["status"] != "LOSS") {

                        $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", [$statusChangeStatus, $orderMenu["id"]]);
                    }
                }
                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                $ohistory = $db->iud("INSERT INTO `order_history`(`date_time`,`process`,`order_id`)VALUES(?,?,?)", "ssi", [$date, $statusChangeStatus,  $orderManuResult[0]["order_id"]]);
                $db->iud("UPDATE `order` SET `status`=? ,`note`=? WHERE `id`=?", "ssi", [$statusChangeStatus, "Order Is " . $statusChangeStatus, $orderManuResult[0]["order_id"]]);
                $message->type = "success";
                $message->message = "Status Changed Success";
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
