<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 13/11/17
 * Time: 8:53 AM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/Connection.php";
include_once "../config/TABLES.php";
$database = new Connection();
$db = $database->getDb();

$depts = $db->select(
    TABLES::$dept,
    ["id","name","phone"]
);
$doctors = $db->select(
    TABLES::$doctor,
    ["id","name","dept","qual","phone"]
);
$avail = $db->select(
    TABLES::$avail,
    ["did","day"]
);

print_r(json_encode(array("status"=>1,"depts"=>$depts,"doctors"=>$doctors,"availability"=>$avail)));
