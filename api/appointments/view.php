<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:47 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once "../config/Connection.php";
include_once "../objects/User.php";
include_once "../auth/verify.php";
include_once "../misc/error.php";

/*
 * Token verification
 */
$token = isset($_GET['token'])?$_GET['token']:error(2);
$user = isset($_GET['id']) ? $_GET['id'] : error(2);
if(!verify($token,$user))
    error(1);
$database = new Connection();
$db = $database->getDb();
$app = new Appointment($db,$user);
$pending = $app->getPending();
$history = $app->getHistory();
$appointments =
print_r(json_encode($appointments));