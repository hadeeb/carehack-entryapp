<?php

/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 12/11/17
 * Time: 12:35 AM
 */
require_once "../config/TABLES.php";
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
     */
    public function __construct(\Medoo\Medoo $db)
    {
        $this->db = $db;
        $this->id = 0;
        $this->patients = array();
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

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
        $this->init();
    }

    public function getAppointments()
    {
        $pending = $this->db->select(
            TABLES::$pending,
            ["id","pid","did","date"],
            ["pid"=>$this->patients]
        );
        $pending = array_values($pending);

        $history = $this->db->select(
            TABLES::$history,
            ["id","pid","did","date"],
            ["pid"=>$this->patients]
        );
        $history = array_values($history);
        return array("pending"=>$pending,"history"=>$history);
    }

}