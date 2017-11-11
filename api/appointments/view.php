<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:47 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once "../config/Connection.php";
include_once "../objects/Appointment.php";

$database = new Connection();
$db = $database->db;
$user = isset($_GET['id']) ? $_GET['id'] : die();
$app = new Appointment($db,$user);