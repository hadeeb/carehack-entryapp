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
use Firebase\JWT\JWT;

function verify(string $token, $user)
{
    try{
        $key = (array)JWT::decode($token,Connection::$key, array('HS256'));
        if($key["id"]==(int)$user)
            return true;
    }catch (Exception $e){return false;};
    return false;
}