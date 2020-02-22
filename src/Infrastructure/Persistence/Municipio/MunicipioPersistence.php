<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Municipio;

use App\Domain\Municipio\Municipio;
use App\Domain\Municipio\MunicipioRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class MunicipioPersistence implements MunicipioRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarMunicipio(Municipio $Municipio)
    {
        $sql = "INSERT INTO municipios (Nombre, Id_Departamento, Estado) VALUES (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Municipio->__GET("Nombre"));
            $stm->bindValue(2, $Municipio->__GET("Id_Departamento"));
            $stm->bindValue(3, $Municipio->__GET("Estado"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarMunicipio()
    {
        $sql = "SELECT m.Id_Municipios, m.Nombre AS Municipio , d.Id_Departamento ,  d.Nombre AS Departamento FROM municipios m INNER JOIN departamento d ON (m.Id_Departamento = d.Id_Departamento)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Municipios, int $Estado){
        $sql = "UPDATE municipios SET Estado= ? WHERE Id_Municipios = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Municipios);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatosMunicipio($Id_Municipios){
        $sql = "SELECT m.Id_Municipios, m.Nombre AS Municipio , d.Id_Departamento ,  d.Nombre AS Departamento FROM municipios m INNER JOIN departamento d ON (m.Id_Departamento = d.Id_Departamento) WHERE Id_Municipios = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Municipios);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarMunicipio(Municipio $Municipio){
        $sql = "UPDATE municipios SET Nombre = ?, Id_Departamento = ?  WHERE Id_Municipios = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Municipio->__GET("Nombre"));
            $stm->bindValue(2, $Municipio->__GET("Id_Departamento"));
            $stm->bindValue(3, $Municipio->__GET("Id_Municipios"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
}
