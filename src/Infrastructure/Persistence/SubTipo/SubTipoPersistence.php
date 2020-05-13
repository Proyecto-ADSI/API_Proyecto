<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\SubTipo;

use App\Domain\SubTipo\SubTipo;
use App\Domain\SubTipo\SubTipoRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class SubTipoPersistence implements SubTipoRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarSubTipo(SubTipo $SubTipo)
    {
        $sql = "INSERT INTO subtipo_barrio_vereda (SubTipo, Estado) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $SubTipo->__GET("SubTipo"));
            $stm->bindValue(2, $SubTipo->__GET("Estado"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarSubTipo()
    {
        $sql = "SELECT Id_SubTipo_Barrio_Vereda, SubTipo, Estado FROM subtipo_barrio_vereda";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_SubTipo_Barrio_Vereda, int $Estado){
        $sql = "UPDATE subtipo_barrio_vereda SET Estado= ? WHERE Id_SubTipo_Barrio_Vereda = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_SubTipo_Barrio_Vereda);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
      public function ValidarSubTipoEliminar(int $Id_SubTipo_Barrio_Vereda){
        $sql = "SELECT Id_Subtipo_Barrio_Vereda FROM barrios_veredas WHERE Id_SubTipo_Barrio_Vereda = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindValue(1, $Id_SubTipo_Barrio_Vereda);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }

      public function EliminarSubTipo(int $Id_SubTipo_Barrio_Vereda)
      {
        $sql = "DELETE FROM subtipo_barrio_vereda WHERE Id_SubTipo_Barrio_Vereda = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindValue(1, $Id_SubTipo_Barrio_Vereda);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
        
  
      public function ObtenerDatosSubTipo(int $Id_SubTipo_Barrio_Vereda){
        $sql = "SELECT Id_SubTipo_Barrio_Vereda, SubTipo  FROM subtipo_barrio_vereda WHERE Id_SubTipo_Barrio_Vereda = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_SubTipo_Barrio_Vereda);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarSubTipo(SubTipo $SubTipo){
        $sql = "UPDATE subtipo_barrio_vereda SET SubTipo = ?  WHERE Id_SubTipo_Barrio_Vereda = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $SubTipo->__GET("SubTipo"));
            $stm->bindValue(2, $SubTipo->__GET("Id_SubTipo_Barrio_Vereda"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
}
