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
    private $name;
    private $age;
    private $gender;

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
            ["name","age","gender"],
            ["id"=>$this->id]
        );
        if($res)
        {
            $this->name = $res["name"];
            $this->age = $res["age"];
            $this->gender = $res["gender"];
            $this->status = true;
        }
    }

    public function getAll()
    {
        if($this->status)
            return array(
                $this->id,
                $this->name,
                (int)$this->age,
                (int)$this->gender,
            );
        else
            return array(0);
    }

}