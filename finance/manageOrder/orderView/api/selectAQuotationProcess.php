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

    require "../../../../service/mailService.php";

    $sessionAdmin = $_SESSION["rb_user"];


    $orderId = $_POST["orderId"];
    $orderManuId = $_POST["orderManuId"];
    $quotationId = $_POST["quotationId"];


    $message = new stdClass();

    if (empty($orderId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if (empty($orderManuId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if (empty($quotationId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        try {

            $db->beginTransaction();

            $orderResult = $db->search("SELECT * FROM `order` WHERE `id`=?", "i", [$orderId]);
            if (count($orderResult) == 1) {

                $orderManuResult = $db->search("SELECT * FROM `order_has_manifacturer` WHERE `order_id`=?", "i", [$orderId]);
                if (count($orderManuResult) > 0) {
                    for ($o = 0; $o < count($orderManuResult); $o++) {
                        $orderMenu = $orderManuResult[$o];
                        $quotationResult = $db->search("SELECT * FROM `quotation` WHERE `order_has_manifacturer_id`=?", "i", [$orderMenu["id"]]);
                        if (count($quotationResult) == 1) {
                            $manuQuotation = $quotationResult[0];
                            if ($manuQuotation["id"] == $quotationId) {

                                $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", ["PROCESSING", $orderMenu["id"]]);

                                $db->iud("INSERT INTO `chat_room`(`order_has_manifacturer_id`,`status`,`user_id`)VALUES(?,?,?)", "isi", [$orderMenu["id"], "ON", $sessionAdmin["id"]]);

                                $manuSelect = $db->search("SELECT * FROM `manifacturer` WHERE `id`=?", "i", [$orderMenu["manifacturer_id"]]);
                                if (count($manuSelect) > 0) {
                                    $body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quotation Selected</title>
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
      Dear '.$manuSelect[0]["name"].',
    </p>
    <p style="font-size: 16px;">
      We are pleased to inform you that your quotation for <strong>'.$orderResult[0]["name"].'</strong> has been selected by Robotic Assistance Devices. Our team has reviewed your submission, and we are excited to proceed with your proposal.
    </p>

    <!-- Next Steps -->
    <div style="background-color: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 8px;">
      <p style="font-size: 16px; margin: 0;">To review the details and next steps, please visit your dashboard:</p>
      <a href="https://www.roboticassistancedevices.com" style="font-size: 16px; color: #3498db; text-decoration: none;">View Details</a>
    </div>

    <!-- Closing Message -->
    <p style="font-size: 16px; margin-top: 20px;">
      If you have any questions, feel free to contact us. We look forward to working with you.<br><br>
      Best regards,<br>
      The Robotic Assistance Devices Team
    </p>

  </div>

</body>
</html>
';
                                    MailSender::sendMail($manuSelect[0]["email"], "Your Quotation Has Been Selected (".$orderResult[0]["name"].")", $body);
                                }
                            } else {
                                $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", ["LOSS", $orderMenu["id"]]);
                            }
                        } else {
                            $db->iud("UPDATE `order_has_manifacturer` SET `status`=? WHERE `id`=?", "si", ["NOT SUBMITTED", $orderMenu["id"]]);
                        }
                    }
                    $db->iud("UPDATE `order` SET `status`=? ,`note`=? WHERE `id`=?", "ssi", ["PROCESSING", "Chat With Manufacturer", $orderId]);
                }
            } else {
            }

            $message->type = "success";
            $message->message = "Quotation Successfully Selected";
            echo json_encode($message);

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            $message->type = "error";
            $message->message = "Processing error Try Again";
            echo json_encode($message);
        }
    }
}
