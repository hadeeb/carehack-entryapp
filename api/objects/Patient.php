<?php

/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 12/11/17
 * Time: 12:41 AM
 */
require_once "../config/TABLES.php";
class Patient
{
    private $db;
    private $id;
    private $loginid;
    private $fname;
    private $lname;
    private $age;
    private $gender;
    private $phone;
    private $address;

    /**
     * Patient constructor.
     * @param $db
     * @param $loginid
     */
    public function __construct(\Medoo\Medoo $db,int $loginid)
    {
        $this->id = 0;
        $this->db = $db;
        $this->loginid = $loginid;
    }

    private function init(int $id)
    {
        $this->id = $id;
        $res = $this->db->get(
            TABLES::$patient,
            ["fname","lname","age","gender","phone","address"],
            ["id"=>$this->id]
        );
        if($res)
        {
            $this->fname = $res["fname"];
            $this->lname = $res["lname"];
            $this->age = $res["age"];
            $this->gender = $res["gender"];
            $this->phone = $res["phone"];
            $this->address = $res["address"];
        }
    }

    public function newUser()
    {
        $this->db->insert(
            TABLES::$patient,
            [
                "loginid"=>$this->loginid,
                "fname"=>$this->fname,
                "lname"=>$this->lname,
                "age"=>$this->age,
                "gender"=>$this->gender,
                "phone"=>$this->phone,
                "address"=>$this->address
            ]
        );
        $this->id = $this->db->id();
        if($this->id>0)
            return true;
        return false;
    }

    public function update()
    {
        $res = $this->db->update(
          TABLES::$patient,
          [
              "fname"=>$this->fname,
              "lname"=>$this->lname,
              "age"=>$this->age,
              "gender"=>$this->gender,
              "phone"=>$this->phone,
              "address"=>$this->address
              ],
          ["id"=>$this->id]
        );
        if($res)
            return true;
        return false;
    }

    public function getAll(int $id)
    {
        $this->init($id);
        if($this->id>0)
            return array(
                $this->id,
                $this->loginid,
                $this->fname,
                $this->lname,
                $this->age,
                $this->gender,
                $this->phone,
                $this->address
            );
        else
            return array(0);
    }

    public function setAll(array $details)
    {
        $this->fname = $details[0];
        $this->lname = $details[1];
        $this->age = $details[2];
        $this->gender = $details[3];
        $this->phone = $details[4];
        $this->address = $details[5];
    }
}