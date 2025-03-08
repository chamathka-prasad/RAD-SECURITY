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

if (isset($_SESSION["rb_manu"])) {
    $manuSession = $_SESSION["rb_manu"];
    $page = $_POST["page"];

    $oname = $_POST["oname"];
    $ostatus = $_POST["ostatus"];
    $odate = $_POST["odate"];


    if (empty($page)) {
        $page = 0;
    }

    $filter = "WHERE `order_has_manifacturer`.`manifacturer_id`='".$manuSession["id"]."' AND `order`.`status`!='CANCELED' ";
    if (!empty($oname)) {
        $filter = $filter ." AND `name`LIKE '%" . $oname . "%'";
    }
    if ($filter == "") {
        if ($ostatus != "ALL") {
            $filter = "WHERE `order_has_manifacturer`.`status`='" . $ostatus . "'";
        }
    } else {
        if ($ostatus != "ALL") {
            $filter = $filter . " AND `order_has_manifacturer`.`status`='" . $ostatus . "'";
        }
    }
    if ($filter == "") {

        $filter = "WHERE `order`.`datetime`LIKE'" . $odate . "%'";
    } else {

        $filter = $filter . " AND `order`.`datetime`LIKE'" . $odate . "%'";
    }

    $offset = ($page - 1) * 25;

    $message = new stdClass();

    $resultCount = $db->search("SELECT COUNT(*) AS total_rows FROM `order_has_manifacturer` INNER JOIN `order` ON `order`.`id`=`order_has_manifacturer`.`order_id`" . $filter);

    $sql = "SELECT `order_has_manifacturer`.`id`,`order`.`name`,`order`.`datetime`,`order_has_manifacturer`.`status`,`order`.`dead_line`,`order_has_manifacturer`.`uid` FROM `order_has_manifacturer` INNER JOIN `order` ON `order`.`id`=`order_has_manifacturer`.`order_id` " . $filter . "ORDER BY `order`.`datetime` DESC LIMIT 25 OFFSET " . $offset;
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


}
