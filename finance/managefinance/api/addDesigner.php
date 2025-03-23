<?php
session_start();
require "../../../config/MySQLConnector.php";
require "../../../service/mailService.php";


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


  $cname = $_POST["cname"];
  $email = $_POST["email"];


  $regex = '/^\+?\d+$/';
  $message = new stdClass();

  if (empty($cname)) {
    $message->type = "error";
    $message->message = "Name is empty";
    echo json_encode($message);
  } else if (empty($email)) {
    $message->type = "error";
    $message->message = "Email is empty";
    echo json_encode($message);
  } else {


    $sql = "SELECT * FROM `user` WHERE name = ?  OR email = ?";
    $result = $db->search($sql, 'ss', [$cname, $email]);


    if (count($result) == 0) {
      $savePath = "";
      if (isset($_FILES["cimg"])) {



        $img = $_FILES["cimg"];


        $ext = pathinfo($img["name"], PATHINFO_EXTENSION);
        $img["type"];
        $fileName = uniqid();
        $savePath = $fileName . "." . $ext;
        $path = "../../../resources/userImg/" . $fileName . "." . $ext;
        move_uploaded_file($img["tmp_name"], $path);
      }
      $password = uniqid();
      $insertManifacturer = $db->iud("INSERT INTO `user`(`name`,`img`,`email`,`password`,`username`,`type`)
            VALUES(?,?,?,?,?,?)", "ssssss", [$cname, $savePath, $email, $password, 'finance' . $password, 'finance']);

      if ($insertManifacturer['affected_rows'] > 0) {

        $body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Details</title>
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
      Dear Finance Officer,
    </p>
    <p style="font-size: 16px;">
      You have been successfully registered as a Finance Officer with Robotic Assistance Devices Application. Please use the following credentials to log in:
    </p>

    <!-- Login Details -->
    <div style="background-color: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 8px;">
      <p style="font-size: 16px; margin: 0;">UserName: <strong>finance' . $password . '</strong></p>
      <p style="font-size: 16px; margin: 5px 0;">Password: <strong>' . $password . '</strong></p>
      <p style="font-size: 16px; margin: 5px 0;">To log in, please click the link below:</p>
      <a href="https://www.roboticassistancedevices.com/login" style="font-size: 16px; color: #3498db; text-decoration: none;">Login Here</a>
    </div>

    <!-- Closing Message -->


    <p style="font-size: 16px;">
      Best regards,<br>
      The Robotic Assistance Devices Team
    </p>
  </div>
  
</body>
</html>
';

        MailSender::sendMail($email, "Robotic Assistance Devices System Registration", $body);

        $message->type = "success";
        $message->message = "Finance Accouint Register Success";
        echo json_encode($message);
      } else {
        $message->type = "error";
        $message->message = "Insert Error";
        echo json_encode($message);
      }
    } else {
      $manifacurer = $result[0];

      $message->type = "error";

      if ($manifacurer["name"] == $cname) {
        $message->message = "Name Is Already Registred.";
      } else {
        $message->message = "Email Is Already Registred.";
      }

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
