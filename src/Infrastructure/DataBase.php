<?php

namespace App\Infrastructure;

use PDO;

class DataBase
{

    private $driver = "mysql";
    private $hostname = "localhost:33065";
    private $username = "root";
    private $password = "";
    private $dbname = "callphone_soft_bd";
    private $conection = null;

    public function getConection()
    {
        return $this->conection;
    }

    function __construct()
    {
        try {

            $strc = "$this->driver:dbname=$this->dbname;host=$this->hostname;charset=utf8";
            $this->conection = new PDO($strc, $this->username, $this->password);
            $this->conection->query("SET lc_time_names = 'es_ES'");
        } catch (\Exception $e) {
            return "Error al conectar con la base de datos: " . $e->getMessage();
        }
    }
}
