<?php

/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 12/11/17
 * Time: 12:35 AM
 */
require_once "../config/TABLES.php";
require_once "../vendor/autoload.php";
class User
{
    private $id;
    private $email;
    private $fname;
    private $lname;
    private $phone;

    private $db;
    private $patients;


    /**
     * User constructor.
     * @param \Medoo\Medoo $db
     * @param int $id
     */
    public function __construct(\Medoo\Medoo $db,int $id)
    {
        $this->db = $db;
        $this->id = $id;
        $this->patients = array();
        $this->init();
    }

    private function init()
    {
        $res = $this->db->select(
            TABLES::$patient,
            ["id"],
            ["loginid"=>$this->id]
        );
        $this->patients = array_values($res);
        $res = $this->db->get(
            TABLES::$user,
            ["self","phone","email"],
            ["id"=>$this->id]
        );
        $this->phone = $res["phone"];
        $this->email = $res["email"];
        $self = $res["self"];
        if($self>0)
        {
            $res = $this->db->get(
                TABLES::$patient,
                ["fname","lname"],
                ["id"=>$self]
            );
            $this->fname = $res["fname"];
            $this->lname = $res["lname"];
        }
    }

    /**
     * @return mixed
     */
    public function getPatients()
    {
        return $this->patients;
    }

    public function newPatient(array $details)
    {
        $fname = $details[0];
        $lname = $details[1];
        $age = $details[2];
        $gender = $details[3];
        $phone = $details[4];
        $address = $details[5];
        $this->db->insert(
            TABLES::$patient,
            [
                "loginid"=>$this->id,
                "fname"=>$fname,
                "lname"=>$lname,
                "age"=>$age,
                "gender"=>$gender,
                "phone"=>$phone,
                "address"=>$address
            ]
        );
        return $this->db->id();
    }

    public function getAppointments()
    {
        $appointments = $this->db->select(
            TABLES::$appointments,
            ["id","pid","did","date","status"],
            ["pid"=>$this->patients]
        );
        return array_values($appointments);
    }

    public function addAppointment(array $details)
    {
        $pid = $details[0];
        $did = $details[1];
        $date = $details[2];

        $this->db->insert(
            TABLES::$appointments,
            [
                "pid"=>$pid,
                "did"=>$did,
                "date"=>$date,
                "status"=>0
            ]
        );

        return $this->db->id();
    }

}