<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Operador;

use App\Domain\Operador\Operador;
use App\Domain\Operador\OperadorRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class OperadorPersistence implements OperadorRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarOperador(Operador $Operador)
    {
        $sql = "INSERT INTO operadores (Nombre_Operador, Estado_Operador) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Operador->__GET("Nombre"));
            $stm->bindValue(2, $Operador->__GET("Estado"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarOperador()
    {
        $sql = "SELECT Id_Operador, Nombre_Operador, Estado_Operador FROM operadores ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Operador, int $Estado){
        $sql = "UPDATE operadores SET Estado_Operador= ? WHERE Id_Operador = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Operador);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatosOperador($Id_Operador){
        $sql = "SELECT Id_Operador, Nombre_Operador FROM operadores   WHERE Id_Operador = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Operador);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarOperador(Operador $Operador){
        $sql = "UPDATE operadores SET Nombre_Operador = ?  WHERE Id_Operador = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Operador->__GET("Nombre"));
            $stm->bindValue(2, $Operador->__GET("Id_Operador"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }    
}
