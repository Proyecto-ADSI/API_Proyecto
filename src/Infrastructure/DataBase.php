<?php

namespace App\Infrastructure;

use PDO;

class DataBase {

    private $driver = "mysql";
    private $hostname = "localhost:3306";
    private $username = "root";
    private $password = "";
    private $dbname = "callphone_soft_bd";
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
            return $e;
        }
    }
}