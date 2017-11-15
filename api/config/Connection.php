<?php
/**
 * Created by PhpStorm.
 * User: farhan
 * Date: 11/11/17
 * Time: 10:28 PM
 */
require_once "../vendor/autoload.php";

use Medoo\Medoo;

class Connection
{
    private $dbName = "hospital";
    private $db = null;
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

    /**
     * @return Medoo|null
     */
    public function getDb()
    {
        return $this->db;
    }
}