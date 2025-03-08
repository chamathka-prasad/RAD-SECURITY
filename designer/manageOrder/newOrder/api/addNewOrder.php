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
require "../../../../service/mailService.php";
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

            $orderAddResult = $db->iud("INSERT INTO `order`(`path`,`datetime`,`dead_line`,`name`,`status`,`note`)VALUES(?,?,?,?,?,?)", "ssssss", [$savePath, $date, $odead, $oname, 'NEW', 'New Order']);

            if ($orderAddResult['affected_rows'] > 0) {


                $orderID = $orderAddResult["last_id"];

                $companyArray = explode(",", $ocomps);


                for ($i = 0; $i < sizeof($companyArray); $i++) {
                    $uid = uniqid() . "rad" . $i;



                    $orderAddManufacturer = $db->iud("INSERT INTO `order_has_manifacturer`(`order_id`,`manifacturer_id`,`status`,`uid`)VALUES(?,?,?,?)", "iiss", [$orderID, $companyArray[$i], 'NEW', $uid]);
                    if ($orderAddManufacturer['affected_rows'] > 0) {
                        $manuResult = $db->search("SELECT * FROM `manifacturer` WHERE `id`=?", "i", [$companyArray[$i]]);
                        if (count($manuResult) > 0) {
                            $body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Order Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; padding: 20px;">

  <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    
    <!-- Company Logo -->
    <div style="text-align: center; margin-bottom: 20px;">
      <img src="cid:logo_cid" alt="Robotic Assistance Devices" style="max-width: 150px;">
    </div>

    <!-- Company Name -->
    <div style="text-align: center; font-size: 24px; font-weight: bold; color: #2c3e50;">
      Robotic Assistance Devices
    </div>

    <!-- Greeting Message -->
    <p style="font-size: 16px; margin-top: 20px;">
      Dear Manufacturer,
    </p>
    <p style="font-size: 16px;">
      You have received a new order request from Robotic Assistance Devices. Please submit your best quotation as soon as possible.
    </p>

    <!-- Instructions -->
    <div style="background-color: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 8px;">
      <p style="font-size: 16px; margin: 0;">To download the quotation details, please visit our website:</p>
      <a href="https://www.roboticassistancedevices.com" style="font-size: 16px; color: #3498db; text-decoration: none;">Visit Our Website</a>
    </div>

    <!-- Closing Message -->
    <p style="font-size: 16px; margin-top: 20px;">
      Please review the details and submit your quotation at your earliest convenience.
    </p>

    <p style="font-size: 16px;">
      Best regards,<br>
      The Robotic Assistance Devices Team
    </p>

  </div>

</body>
</html>
';
                            MailSender::sendMail($manuResult[0]["email"], "You have New Order From Robotic Assistance Devices", $body);
                        }
                    }
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
