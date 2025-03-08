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


    $oname = $_POST["oname"];
    $odead = $_POST["odead"];
    $ocomps = $_POST["ocomps"];


    $message = new stdClass();

    if (empty($oname)) {
        $message->type = "error";
        $message->message = "Order Name Is Empty";
        echo json_encode($message);
    } else if (empty($odead)) {
        $message->type = "error";
        $message->message = "Quotation Deadline is empty";
        echo json_encode($message);
    } else if (empty($ocomps)) {
        $message->type = "error";
        $message->message = "Please Select Manufacturers";
        echo json_encode($message);
    } else {

        if (isset($_FILES["ozip"])) {

            $img = $_FILES["ozip"];

            $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
            $img["type"];
            $fileName = uniqid();
            $savePath = $fileName . "." . $ext;
            $path = "../../../../resources/orders/" . $fileName . "." . $ext;


            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            $orderAddResult = $db->iud("INSERT INTO `order`(`path`,`datetime`,`dead_line`,`name`,`status`,`note`)VALUES(?,?,?,?,?,?)", "ssssss", [$savePath, $date, $odead, $oname, 'PENDING', 'New Order']);

            if ($orderAddResult['affected_rows'] > 0) {


                $orderID = $orderAddResult["last_id"];

                $companyArray = explode(",", $ocomps);


                for ($i = 0; $i < sizeof($companyArray); $i++) {
                    $uid = uniqid() . "rad" . $i;

                    $orderAddManufacturer = $db->iud("INSERT INTO `order_has_manifacturer`(`order_id`,`manifacturer_id`,`status`,`uid`)VALUES(?,?,?,?)", "iiss", [$orderID, $companyArray[$i], 'NEW', $uid]);
                }

                $message->type = "success";
                $message->message = "Order Added Success";
                move_uploaded_file($img["tmp_name"], $path);
                echo json_encode($message);
            } else {
                $message->type = "error";
                $message->message = "Insert Error";
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Please Select a Zip File";
            echo json_encode($message);
        }
    }
}
