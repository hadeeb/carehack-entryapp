<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:28 PM
 */
require "Medoo.php";

use Medoo\Medoo;

class Connection
{
    /*
     *  Connection variables
     */
    private $dbName = "hospital";
    public $tbAppHistory = "apphistory";
    public $tbAppPending = "apppending";
    public $tbDept = "dept";
    public $tbDoctor = "doctor";
    public $tbPatient = "patient";
    public $tbUser = "user";
    public $tbDoctorAvail = "doctoravail";

    public $db;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->db = new Medoo(
            [
                'database_type' => 'mysql',
                'database_name' => $this->dbName,
                'server' => 'localhost',
                'username' => 'dude',
                'password' => 'dude123',
            ]
        );
    }


}