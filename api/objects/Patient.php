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
    private $status;
    private $fname;
    private $lname;
    private $age;
    private $gender;
    private $phone;
    private $address;

    /**
     * Patient constructor.
     * @param \Medoo\Medoo $db
     * @param int $id
     * @internal param $loginid
     */
    public function __construct(\Medoo\Medoo $db,int $id)
    {
        $this->id = $id;
        $this->db = $db;
        $this->status = false;
        $this->init();
    }

    private function init()
    {
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
            $this->status = true;
        }
    }
/*
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
*/
    public function getAll()
    {
        if($this->status)
            return array(
                $this->id,
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

}