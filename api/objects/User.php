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
    private $self;
    private $phone;
    private $name;

    private $db;
    private $patients;


    /**
     * User constructor.
     * @param \Medoo\Medoo $db
     * @param int $id
     */
    public function __construct(\Medoo\Medoo $db,$id)
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
        foreach ($res as $key => $value)
            $this->patients[] = $value["id"];
        $res = $this->db->get(
            TABLES::$user,
            ["self","phone","email"],
            ["id"=>$this->id]
        );
        $this->phone = $res["phone"];
        $this->email = $res["email"];
        $this->self  = $res["self"];
        if($this->self>0)
        {
            $res = $this->db->get(
                TABLES::$patient,
                ["name"],
                ["id"=>$this->self]
            );
            $this->name = $res["name"];
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
        $name = $details[0];
        $age = $details[1];
        $gender = $details[2];
        $this->db->insert(
            TABLES::$patient,
            [
                "loginid"=>$this->id,
                "name"=>$name,
                "age"=>$age,
                "gender"=>$gender
            ]
        );
        return $this->db->id();
    }

    public function getAppointments()
    {
        $appointments = $this->db->select(
            TABLES::$appointments,
            ["id","pid","did","date"],
            ["pid"=>$this->patients]
        );
        foreach ($appointments as $appointment) {
            $appointments[$appointment]["doctor"] = $this->db->get(
                TABLES::$doctor,
                ["name"],
                ["id"=>$appointments[$appointment]["did"]]
            );
        }
        return array_values($appointments);
    }

    public function addAppointment(array $details)
    {
        $pid = $this->self;
        $did = $details[0];
        $date = $details[1];

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