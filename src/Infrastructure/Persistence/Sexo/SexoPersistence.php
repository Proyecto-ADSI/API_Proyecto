<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sexo;

use App\Domain\Sexo\Sexo;
use App\Domain\Sexo\SexoRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class SexoPersistence implements SexoRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarSexo(Sexo $Sexo)
    {
        $sql = "INSERT INTO sexos(Nombre,Estado) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Sexo->__GET("Nombre"));
            $stm->bindValue(2, $Sexo->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarSexo()
    {
        $sql = "SELECT Id_Sexo, Nombre,Estado FROM sexos";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Sexo, int $Estado){
        $sql = "UPDATE sexos SET Estado= ? WHERE Id_Sexo = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Sexo);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatos($Id_Sexo){
        $sql = "SELECT * FROM sexos WHERE Id_Sexo = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Sexo);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarSexo(Sexo $Sexo){
        $sql = "UPDATE sexos SET Nombre = ?  WHERE Id_Sexo = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Sexo->__GET("Nombre"));
            $stm->bindValue(2, $Sexo->__GET("Id_Sexo"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
}
