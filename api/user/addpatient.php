<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 15/11/17
 * Time: 10:15 AM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../auth/verify.php";
include_once  "../config/Connection.php";
include_once  "../misc/error.php";

$id = isset($_POST['id'])?$_POST['id']:error(2);
$token = isset($_POST["token"])?$_POST["token"]:error(2);

$name    = isset($_POST['name'])    ? $_POST['name']    : error(2);
$age     = isset($_POST['age'])     ? $_POST['age']     : error(2);
$gender  = isset($_POST['gender'])  ? $_POST['gender']  : error(2);

if(verify($token,$id)) {
    $db = new Connection();
    $db = $db->getDb();
    $user = new User($db, $id);
    $user->newPatient(array($name,$age,$gender));
    error(1);
}