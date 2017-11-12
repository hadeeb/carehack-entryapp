<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 12/11/17
 * Time: 2:51 AM
 * @param int $id
 * @return int
 */
function error(int $id)
{
    switch ($id)
    {
        case 1:
            //Invalid Token
            print_r(json_encode(array("status"=>0,"message"=>"Token verification failed")));
            break;
        case 2:
            //Missing keys
            print_r(json_encode(array("status"=>0,"message"=>"Parameters missing")));
            break;
        case 3:
            //Login fail
            print_r(json_encode(array("status"=>0,"message"=>"Login failed")));
            break;
    }
    die();
}