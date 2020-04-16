<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pais;

use App\Domain\Pais\Pais;
use App\Domain\Pais\PaisRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class PaisPersistence implements PaisRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarPais(Pais $Pais)
    {
        $sql = "INSERT INTO pais(Nombre_Pais,Estado) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Pais->__GET("Nombre"));
            $stm->bindValue(2, $Pais->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarPais()
    {
        $sql = "SELECT Id_Pais, Nombre_Pais,Estado FROM pais";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Pais, int $Estado){
        $sql = "UPDATE pais SET Estado= ? WHERE Id_Pais = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Pais);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatos($Id_Pais){
        $sql = "SELECT * FROM pais WHERE Id_Pais = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Pais);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function EliminarPais(int $Id_Pais){

        $sql = "DELETE FROM pais WHERE Id_Pais = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Pais);

            return $stm->execute();

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function ValidarPaisEliminar(int $Id_Pais){

        $sql = "SELECT Id_Pais FROM departamentos WHERE Id_Pais = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Pais);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function EditarPais(Pais $Pais){
        $sql = "UPDATE pais SET Nombre_Pais = ?  WHERE Id_Pais = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Pais->__GET("Nombre"));
            $stm->bindValue(2, $Pais->__GET("Id_Pais"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
