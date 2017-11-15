<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 13/11/17
 * Time: 3:28 AM
 */

include_once "verify.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$id = isset($_POST['id'])?$_POST['id']:0;
$token = isset($_POST["token"])?$_POST["token"]:"0";

file_put_contents("log.txt",$id.PHP_EOL,FILE_APPEND|LOCK_EX);


if(verify($token,$id))
{
    $new = false;
    if(isNewUser($id))
    {
        $new = true;
    }

    print_r(json_encode(array("status"=>1,"new"=>$new)));
}
else
    print_r(json_encode(array("status"=>0)));
