<?php

/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 11:03 PM
 */
class Appointment
{
    private $db;
    private $user;

    private $tbhistory = "apphistory";
    private $tbpending = "apppending";

    /**
     * Appointment constructor.
     * @param $db
     * @param $user
     */
    public function __construct($db, $user)
    {
        $this->db = $db;
        $this->user = $user;
    }


}