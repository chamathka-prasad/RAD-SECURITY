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

    require "../../../../service/mailService.php";
    //     $sessionAdmin = $_SESSION["rb_admin"];


    $chatroomId = $_POST["chatroomId"];


    $message = new stdClass();

    if (empty($chatroomId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if (!isset($_FILES["chatFile"])) {
        $message->type = "error";
        $message->message = "Empty File";
        echo json_encode($message);
    } else {


        $chatRoomResult = $db->search("SELECT * FROM `chat_room` WHERE `id`=?", "i", [$chatroomId]);

        if (count($chatRoomResult) == 1) {


            $img = $_FILES["chatFile"];

            $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
            $img["type"];
            $fileName = uniqid();
            $savePath = $fileName . "." . $ext;
            $path = "../../../../resources/chat/" . $fileName . "." . $ext;

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");
            $chatroom = $chatRoomResult[0];
            $chatResult = $db->iud("INSERT INTO `chat`(`datetime`,`chat_room_id`,`type`,`message`,`is_view`,`person`)VALUES(?,?,?,?,?,?)", "sissis", [$date, $chatroom["id"], 'file', $savePath, 0, 'manufacturer']);
            if ($chatResult['affected_rows'] > 0) {


                $designerSearch = $db->search("SELECT * FROM `user` WHERE `type` = ?", 's', ['designer']);
                if (count($designerSearch) > 0) {

                    $manuDetails = $db->search("SELECT manifacturer.email,order.name FROM `order_has_manifacturer` INNER JOIN  `manifacturer` ON `manifacturer`.`id`=`order_has_manifacturer`.`manifacturer_id` INNER JOIN `order` ON `order`.`id`=`order_has_manifacturer`.`order_id` WHERE `order_has_manifacturer`.`id`=?", 'i', [$chatroom["order_has_manifacturer_id"]]);
                    if (count($manuDetails) > 0) {
                        $body = '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <title>New Message Notification</title>
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
                              Dear Designer,
                            </p>
                            <p style="font-size: 16px;">
                              You have received a new File from <strong>' . $_SESSION["rb_manu"]["name"] . '</strong> at ' . $date . '<strong></strong>.
                            </p>
                                  </p>
                                                    <p style="font-size: 16px;">
                                                  Order: <strong>' . $manuDetails[0]["name"] . '</strong>.
                                                </p>
                        
                            <!-- Message Details -->
                            <div style="background-color: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 8px;">
                              <p style="font-size: 16px; margin: 0;">To view the message, please visit your dashboard:</p>
                              <a href="https://www.roboticassistancedevices.com" style="font-size: 16px; color: #3498db; text-decoration: none;">View Message</a>
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
                        MailSender::sendMail($designerSearch[0]["email"], "You have New Message From " . $_SESSION["rb_manu"]["name"], $body);
                    }
                }
                $message->type = "success";
                $message->message = "Message Sent";
                move_uploaded_file($img["tmp_name"], $path);
                echo json_encode($message);
            } else {
                $message->type = "error";
                $message->message = "Some Thing Went Wrong Try Again.";
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid Request";
            echo json_encode($message);
        }
    }
}
