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
    private $patient;

    /**
     * Appointment constructor.
     * @param $db
     * @param $patient
     */
    public function __construct(Medoo $db,int $patient)
    {
        $this->db = $db;
        $this->patient = $patient;
        $this->init();
    }

    private function init()
    {

    }

    public function getPending()
    {
        $res = $this->db->select(
            TABLES::$pending,
            ["id","pid","did","date"],
            ["pid"=>$this->patient]
        );
        return array_values($res);
    }

    public function getHistory()
    {
        $res = $this->db->select(
            TABLES::$history,
            ["id","pid","did","date"],
            ["pid"=>$this->patient]
        );
        return array_values($res);
    }


}