<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:48 PM
 * function Token verifier
 * @param string $token
 * @return bool
 */

require_once "../vendor/autoload.php";
require_once "../config/Connection.php";
require_once "../config/TABLES.php";

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


function verify(string $idToken, $userId)
{

    try{
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');
        $apiKey = "AIzaSyA6NH0ntC4SQVxlG6AOFozRBnaq8p60RRI";
        $firebase = (new Factory)
            ->withServiceAccountAndApiKey($serviceAccount,$apiKey)
            ->create();

        $auth = $firebase->getAuth();
        $idToken = $auth->verifyIdToken($idToken);

        $uid = $idToken->getClaim('sub');

        if ($uid == $userId)
            return true;



        return false;

    }catch (Exception $e){ return false;}
}

function isNewUser($uid)
{
    $db = new Connection();
    $db = $db->getDb();

    $passkey = $db->get(
        TABLES::$user,
        ["phone","email","self"],
        ["id"=>$uid]
    );
    file_put_contents("log.txt",$passkey["phone"],8);
    if(is_array($passkey)&&sizeof($passkey)>0 && $passkey["self"]>0)
        return false;

    return true;

}
