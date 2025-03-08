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

if (isset($_SESSION["rb_manu"])) {


    $sessionManufacturer = $_SESSION["rb_manu"];


    $onumber = $_POST["orderNumber"];


    $regex = '/^\+?\d+$/';
    $message = new stdClass();

    if (empty($onumber)) {
        $message->type = "error";
        $message->message = "INVALID Request";
        echo json_encode($message);
    } else if (!isset($_FILES["qzip"])) {
        $message->type = "error";
        $message->message = "Please Upload A Quotation";
        echo json_encode($message);
    } else {

        $sql = "SELECT * FROM order_has_manifacturer WHERE uid = ?";
        $result = $db->search($sql, 's', [$onumber]);


        if (count($result) == 1) {
            $savePath = "";
            if (isset($_FILES["qzip"])) {
                $orderDetails = $result[0];

                $img = $_FILES["qzip"];
                $sqlquosearch = "SELECT * FROM quotation WHERE order_has_manifacturer_id = ?";
                $resultquotsearch = $db->search($sqlquosearch, 'i', [$orderDetails["id"]]);

                if (count($resultquotsearch) > 0) {
                    $message->type = "error";
                    $message->message = "quotation Already Submited";
                    echo json_encode($message);
                } else {

                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $date = $d->format("Y-m-d H:i:s");

                    $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                    $img["type"];
                    $fileName = uniqid();
                    $savePath = $fileName . "." . $ext;
                    $path = "../../../../resources/quotations/" . $fileName . "." . $ext;
                    move_uploaded_file($img["tmp_name"], $path);

                    $insertManifacturerQuotation = $db->iud("INSERT INTO `quotation`(`datetime`,`path`,`order_has_manifacturer_id`)VALUES(?,?,?)", "ssi", [$date, $savePath, $orderDetails["id"]]);

                    $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", ["PENDING", $orderDetails["id"]]);


                    if ($insertManifacturerQuotation['affected_rows'] > 0) {

                        $sendOrder = $db->search("SELECT * FROM `order` WHERE `id`=?", 'i', [$orderDetails["order_id"]]);
                        if (count($sendOrder) > 0) {
                            $financeSearch = $db->search("SELECT * FROM `user` WHERE `type` = ?", 's', ['finance']);
                            if (count($financeSearch) > 0) {
                                $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>New Quotation Submission</title>
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
          Dear Finance Team,
        </p>
        <p style="font-size: 16px;">
          A new quotation has been submitted by <strong>' . $sessionManufacturer["name"] . '</strong> on <strong>' . $date . '</strong>.
        </p>
         <p style="font-size: 16px;">
          Order : <strong>' . $sendOrder[0]["name"] . '</strong>.
        </p>
    
        <!-- Quotation Details -->
        <div style="background-color: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 8px;">
          <p style="font-size: 16px; margin: 0;">Please review the submission on our platform.</p>
          <a href="https://www.roboticassistancedevices.com" style="font-size: 16px; color: #3498db; text-decoration: none;">Visit the Dashboard</a>
        </div>
    
        <!-- Closing Message -->
        <p style="font-size: 16px; margin-top: 20px;">
          Best regards,<br>
          The Robotic Assistance Devices Team
        </p>
    
      </div>
    
    </body>
    </html>
    ';

                                MailSender::sendMail($financeSearch[0]["email"], "You have New Quotation From " . $sessionManufacturer["name"], $body);
                            }
                        }




                        $message->type = "success";
                        $message->message = "Quotation Submited Success";
                        echo json_encode($message);
                    } else {

                        $message->type = "error";
                        $message->message = "Insert Fail";
                        echo json_encode($message);
                    }
                }
            } else {
                $message->type = "error";
                $message->message = "quotation Not Found";
                echo json_encode($message);
            }
        } else {

            $message->type = "error";
            $message->message = "Processing Error";

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
