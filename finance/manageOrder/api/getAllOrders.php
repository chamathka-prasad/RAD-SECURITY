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


    $page = $_POST["page"];

    $oname = $_POST["oname"];
    $ostatus = $_POST["ostatus"];
    $odate = $_POST["odate"];


    if (empty($page)) {
        $page = 0;
    }

    $filter = "";
    if (!empty($oname)) {
        $filter = "WHERE `name`LIKE '%" . $oname . "%'";
    }
    if ($filter == "") {
        if ($ostatus != "ALL") {
            $filter = "WHERE `status`='" . $ostatus . "'";
        }
    } else {
        if ($ostatus != "ALL") {
            $filter = $filter . " AND `status`='" . $ostatus . "'";
        }
    }
    if ($filter == "") {

        $filter = "WHERE `datetime`LIKE'" . $odate . "%'";
    } else {

        $filter = $filter . " AND `datetime`LIKE'" . $odate . "%'";
    }

    $offset = ($page - 1) * 25;

    $message = new stdClass();

    $resultCount = $db->search("SELECT COUNT(*) AS total_rows FROM `order`" . $filter);

    $sql = "SELECT `id`,`path`,`datetime`,`name`,`status`,`note` FROM `order`" . $filter . "ORDER BY `datetime` DESC LIMIT 25 OFFSET " . $offset;
    $result = $db->search($sql);
    $rowCount = $resultCount[0]["total_rows"];
    $count = intval($rowCount / 25);
    if ($rowCount % 25 != 0) {
        $count = $count + 1;
    }

    $message->message = $result;
    $message->type = "success";
    $message->buttoncount = $count;

    echo json_encode($message);



    // $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");


    // if ($resultsUser->num_rows == 0) {



    // } else {
    //     $message->type = "error";
    //     $message->message = "Invalid Email";
    //     echo json_encode($message);
    // }

}
