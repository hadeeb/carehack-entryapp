<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:47 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/Connection.php";
include_once "../objects/User.php";
include_once "../auth/verify.php";
include_once "../misc/error.php";

$token = isset($_POST["token"])?$_POST["token"]:error(2);
$user = isset($_POST["id"]) ? $_POST["id"] : error(2);
if(!verify($token,$user))
    error(1);
$database = new Connection();
$db = $database->getDb();
$app = new User($db,$user);
$array = $app->getAppointments();
file_put_contents("log1.txt",json_encode($user),8);
print_r(json_encode(array("status"=>1,"appointments"=>$array)));