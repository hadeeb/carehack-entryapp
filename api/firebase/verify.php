<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 14/11/17
 * Time: 9:09 AM
 */

include_once $_SERVER['DOCUMENT_ROOT']."/api/vendor/autoload.php";

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

function verify(string $idToken,string $userId)
{
try {
    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');
    $apiKey = "AIzaSyA6NH0ntC4SQVxlG6AOFozRBnaq8p60RRI";
    $firebase = (new Factory)
        ->withServiceAccountAndApiKey($serviceAccount,$apiKey)
        ->create();

    $auth = $firebase->getAuth();

    $idToken = $auth->verifyIdToken($idToken);

    $uid = $idToken->getClaim('sub');

    if ($uid == $userId)
    {

        return true;
    }


    return false;
}
catch (Exception $exception)
{
    echo $exception->getMessage();
    return false;
}

}
