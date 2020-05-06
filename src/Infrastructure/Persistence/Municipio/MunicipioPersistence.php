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
        $sql = "INSERT INTO municipios (Nombre_Municipio, Id_Departamento, Estado) VALUES (?,?,?)";

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
        $sql = "SELECT m.Id_Municipio, m.Nombre_Municipio,m.Estado ,d.Id_Departamento,d.Nombre_Departamento 
        FROM municipios m INNER JOIN departamento d ON (m.Id_Departamento = d.Id_Departamento)";

        try {
            // return $this->db;

            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
                // return "hola";
                
            } else {
                return $stm->errorInfo();
            }

        } catch (Exception $e) {
            return "Error al listar" . $e->getMessage();
        }
    }

    public function EliminarMunicipio(int $Id_Municipio){

        $sql = "DELETE FROM municipios WHERE Id_Municipio = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Municipio);

            return $stm->execute();

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function ValidarEliminarMunicipio(int $Id_Municipio){

        $sql = "SELECT Id_Municipio FROM barrios_veredas WHERE Id_Municipio = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Municipio);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Municipio, int $Estado){
        $sql = "UPDATE municipios SET Estado= ? WHERE Id_Municipio = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Municipio);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatosMunicipio($Id_Municipio){
        $sql = "SELECT m.Id_Municipio, m.Nombre_Municipio, d.Id_Departamento, d.Nombre_Departamento FROM municipios m 
        INNER JOIN departamento d ON (m.Id_Departamento = d.Id_Departamento) WHERE Id_Municipio = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Municipio);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarMunicipio(Municipio $Municipio){
        $sql = "UPDATE municipios SET Nombre_Municipio = ?, Id_Departamento = ?  WHERE Id_Municipio = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Municipio->__GET("Nombre"));
            $stm->bindValue(2, $Municipio->__GET("Id_Departamento"));
            $stm->bindValue(3, $Municipio->__GET("Id_Municipio"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarMunicipiosDepartamento(int $Id_Departamento){

        $sql = "SELECT Id_Municipio, Nombre_Municipio FROM municipios WHERE Id_Departamento = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Departamento);
            $stm->execute();    
            
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }


    



    
}
