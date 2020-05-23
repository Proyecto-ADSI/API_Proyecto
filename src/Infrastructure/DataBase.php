<?php

namespace App\Infrastructure;

use PDO;

class DataBase {

    private $driver = "mysql";
    private $hostname = "bzfcmcwaqz9yq6xpeyqy-mysql.services.clever-cloud.com";
    private $username = "u31p2zhfh2zm9hts";
    private $password = "YymZN71iDEuH8VF1TQW1";
    private $dbname = "bzfcmcwaqz9yq6xpeyqy";
    private $conection = null;
    
    public function getConection(){
        return $this->conection;
    }

    function __construct()
    {
        try{

            $strc = "$this->driver:dbname=$this->dbname;host=$this->hostname";
            $this->conection = new PDO($strc, $this->username, $this->password);
        
        }catch(\Exception $e){
            return "Error al conectar con la base de datos: " . $e->getMessage();
        }
    }
}