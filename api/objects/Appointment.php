<?php

/**
 * Created by PhpStorm.
 * patient: farhan
 * Date: 11/11/17
 * Time: 11:03 PM
 */
require_once "../config/TABLES.php";
require_once "../vendor/autoload.php";
use Medoo\Medoo;
class Appointment
{
    private $db;
    private $id;
    private $patient;
    private $doctor;
    private $date;
    private $status;

    /**
     * Appointment constructor.
     * @param Medoo $db
     * @param int $id
     * @internal param $patient
     */
    public function __construct(Medoo $db,int $id)
    {
        $this->db = $db;
        $this->id = $id;
        $this->init();
    }

    private function init()
    {
        $res = $this->db->get(
            TABLES::$appointments,
            ["pid","did","date","status"],
            ["id"=>$this->id]
        );
        if($res)
        {
            $this->patient = $res["pid"];
            $this->doctor = $res["did"];
            $this->date = $res["date"];
            $this->status = $res["status"];
        }
    }

    public function getAll()
    {
        return array(
            $this->patient,
            $this->doctor,
            $this->date,
            $this->status
        );
    }

    public function cancel()
    {
        if($this->status<1)
        {
            $res = $this->db->delete(
                TABLES::$appointments,
                ["id"=>$this->id]
            );
            if($res)
                return 1;
        }

        return 0;
    }

    static function available(Medoo $db,$did,$date)
    {
        $time = strtotime($date);
        $day = $date('D',$time);

        $num = self::dayToNum($day);

        $res = $db->select(
            TABLES::$avail,
            ["day"],
            ["did"=>$did]
        );
        if($res)
        {
            foreach ($res as $row)
                if($row["day"]==$num)
                    return true;
        }
        return false;
    }

    static function dayToNum($day)
    {
        $num = 0;
        switch ($day)
        {
            case "Sun":$num = 1;break;
            case "Mon":$num = 2;break;
            case "Tue":$num = 3;break;
            case "Wed":$num = 4;break;
            case "Thu":$num = 5;break;
            case "Fri":$num = 6;break;
            case "Sat":$num = 7;break;
        }
        return $num;
    }

}