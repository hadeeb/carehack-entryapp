<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 13/11/17
 * Time: 10:45 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

$about = array();
$about["status"]=1;
$about["team"][] = array("alias"=>"GobL1n","name"=>"Hadeeb Farhan","github"=>"hadeeb","email"=>"hadeebfarhan1@gmail.com");
$about["team"][] = array("alias"=>"kodiyeri","name"=>"Ankith TV","github"=>"tvankith","email"=>"tvankith@gmail.com");
$about["team"][] = array("alias"=>"white","name"=>"Anandu S","github"=>"","email"=>"anandu97@gmail.com");
$about["team"][] = array("alias"=>"Ghost","name"=>"Rahul R","github"=>"","email"=>"rahul.fcb11@gmail.com");

print_r(json_encode($about));
