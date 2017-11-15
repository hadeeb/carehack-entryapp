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
include_once "../objects/User.php";
include_once "../objects/Appointment.php";

$token = isset($_POST['token'])?$_POST['token']:error(2);
$user = isset($_POST['id']) ? $_POST['id'] : error(2);
if(!verify($token,$user))
    error(1);

$did = isset($_POST['did'])  ? $_POST['did']  : error(2);
$date= isset($_POST['date']) ? $_POST['date'] : error(2);

$database = new Connection();
$db = $database->getDb();
$user = (int)$user;
$userObj = new User($db,$user);
if(Appointment::available($db,$did,$date))
    {
        $res = $userObj->addAppointment(array($did,$date));
        error(1);
    }
else
    error(4);