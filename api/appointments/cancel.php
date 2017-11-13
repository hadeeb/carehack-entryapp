<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:47 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../vendor/autoload.php";
include_once "../misc/error.php";
include_once "../config/Connection.php";
include_once "../config/TABLES.php";
include_once "../auth/verify.php";

$token = isset($_POST['token'])?$_POST['token']:error(2);
$user = isset($_POST['id']) ? $_POST['id'] : error(2);
if(!verify($token,$user))
    error(1);

$appid = isset($_POST['appid']) ? $_POST['appid'] : error(2);

$database = new Connection();
$db = $database->getDb();
$appid = (int)$appid;
$app = new Appointment($db,$appid);
$res = $app->cancel();

if($res>0)
    print_r(json_encode(array("status"=>1)));
else
    error(4);