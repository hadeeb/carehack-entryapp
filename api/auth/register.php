<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:26 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*
 * Testing
 * Migrate login and register to fb and google
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../vendor/autoload.php";
include_once "verify.php";
include_once "../misc/error.php";

$token   = isset($_POST['token'])   ? $_POST['token']   : error(2);
$uid     = isset($_POST['uid'])     ? $_POST['uid']     : error(2);
$phone   = isset($_POST['phone'])   ? $_POST['phone']   : error(2);
$email   = isset($_POST['email'])   ? $_POST['email']   : error(2);
$name    = isset($_POST['name'])    ? $_POST['name']    : error(2);
$age     = isset($_POST['age'])     ? $_POST['age']     : error(2);
$address = isset($_POST['address']) ? $_POST['address'] : error(2);
$gender  = isset($_POST['gender'])  ? $_POST['gender']  : error(2);

if(verify($token,$uid))
{
    if(isNewUser($uid))
    {
        $res = register($uid,$phone,$email,$address);
        if(!res) {
            error(4);
        }
    }
     add_details($uid,$name,$age,$gender);
    error(1);

}else
    error(3);

/**
 * @param $uid
 * @param $phone
 * @param $email
 * @param $address
 * @return bool
 */
function register($uid, $phone, $email,$address)
{
    $db = new Connection();
    $db = $db->getDb();
    $phone = substr($phone,3);

    $res = $db->insert(
        TABLES::$user,
        [
            "id"=>$uid,
            "phone"=>$phone,
            "email"=>$email,
            "address"=>$address
            ]
    );
    if($res)
    {
        $id = $db->id();
        if($id == $uid)
            return true;
    }
    return false;
}

/**
 * @param $uid
 * @param $name
 * @param $age
 * @param $gender
 */
function add_details($uid, $name, $age, $gender)
{
    $db = new Connection();
    $db = $db->getDb();

    $res = $db->get(
        TABLES::$user,
        ["self"],
        ["id"=>$uid]
    );
    if($res["self"] == 0)
    {
        $res = $db->insert(
            TABLES::$patient,
            [
                "loginid"=>$uid,
                "name"=>$name,
                "age"=>$age,
                "gender"=>$gender,
            ]
        );
        $id = $db->id();

        $db->update(
            TABLES::$user,
            ["self"=>$id],
            ["id"=>$uid]
        );
    }
    else
    {
        $id = $res["self"];
        $res = $db->update(
            TABLES::$patient,
            [
                "loginid"=>$uid,
                "name"=>$name,
                "age"=>$age,
                "gender"=>$gender,
            ],
            ["id"=>$id]
        );
    }
}