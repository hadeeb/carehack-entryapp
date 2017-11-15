<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 15/11/17
 * Time: 12:31 AM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../auth/verify.php";
include_once  "../config/Connection.php";
include_once  "../misc/error.php";
include_once "../objects/User.php";
include_once "../objects/Patient.php";


$id = isset($_POST["id"])?$_POST["id"]:error(2);
$token = isset($_POST["token"])?$_POST["token"]:error(2);

if(verify($token,$id))
{
    $db = new Connection();
    $db = $db->getDb();
    $user = new User($db,$id);
    $patients = $user->getPatients();
    $patientlist = array();
    foreach ($patients as $patientId)
    {
        file_put_contents("log.txt",json_encode($patientId),8);
        $patientlist[] = (new Patient($db,$patientId["id"]))->getAll();
    }
    print_r(json_encode(array("status"=>1,"patients"=>$patientlist)));
}
else
    error(3);