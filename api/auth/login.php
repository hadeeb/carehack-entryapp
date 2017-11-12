<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:10 PM
 */
include_once "../vendor/autoload.php";
include_once "../misc/error.php";
include_once "../config/Connection.php";

use Firebase\JWT\JWT;

$database = new Connection();
$db = $database->getDb();

$password = isset($_POST['password']) ? $_POST['password'] : error(2);
$phone = 0;
if (isset($_POST['email']) && strlen($_POST['email'])>0) {
    $email = $_POST['email'];
    generateToken(1,$_POST['email'],$password);
    die();
} elseif (isset($_POST['phone']) && strlen($_POST['phone'])==10 && strlen((int)$_POST["phone"])==10) {
    generateToken(2,(int)$_POST["phone"],$password);
    die();
}else
    error(2);

function generateToken($type,$login,$password)
{
    global $db;
    $col = "email";
    if($type == 2)
        $col = "phone";

    $passkey = $db->get(
        TABLES::$user,
        ["password"],
        [$col=>$login]
    );
    $hash = $passkey["password"];
    if(!password_verify($password,$hash) )
        error(3);

    $id = $db->get(
        TABLES::$user,
        ["id"],
        [$col=>$login]
    );

    $key["id"] = $id;

    $token = JWT::encode($key,Connection::$key);

    print_r(json_encode(
        array("status"=>1,"token"=>$token)
    ));
}