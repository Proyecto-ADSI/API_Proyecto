<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Departamento;

use App\Domain\Departamento\Departamento;
use App\Domain\Departamento\DepartamentoRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class DepartamentoPersistence implements DepartamentoRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarDepartamento(Departamento $Departamento)
    {
        $sql = "INSERT INTO departamento(Nombre_Departamento, Id_Pais, Estado_Departamento) VALUES (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Departamento->__GET("Nombre"));
            $stm->bindValue(2, $Departamento->__GET("Id_Pais"));
            $stm->bindValue(3, $Departamento->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarDepartamento()
    {
        $sql = "SELECT d.Id_Departamento, d.Nombre_Departamento,d.Estado_Departamento, p.Id_Pais, p.Nombre_Pais
        FROM departamento d INNER JOIN pais p ON (d.Id_Pais = p.Id_Pais)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Departamento, int $Estado){
        $sql = "UPDATE departamento SET Estado_Departamento= ? WHERE Id_Departamento = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Departamento);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatosDepartamento($Id_Departamento){
        $sql = "SELECT d.Id_Departamento, d.Nombre_Departamento, p.Id_Pais , p.Nombre_Pais
        FROM departamento d INNER JOIN pais p ON (d.Id_Pais = p.Id_Pais) WHERE Id_Departamento = ?";

        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Departamento);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarDepartamento(Departamento $Departamento){
        $sql = "UPDATE departamento SET Nombre_Departamento = ?, Id_Pais = ?  WHERE Id_Departamento = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Departamento->__GET("Nombre"));
            $stm->bindValue(2, $Departamento->__GET("Id_Pais"));
            $stm->bindValue(3, $Departamento->__GET("Id_Departamento"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarDepartamento(int $Id_Departamento){

        $sql = "DELETE FROM departamento WHERE Id_Departamento = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Departamento);

            return $stm->execute();

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function ValidarDepartamentoEliminar(int $Id_Departamento){

        $sql = "SELECT Id_Departamento FROM municipio WHERE Id_Departamento = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Departamento);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){

            return $e->getMessage();
        }
    }


    public function ConsultarDepartamentosPais(int $Id_Pais){

        $sql = "SELECT Id_Departamento, Nombre_Departamento FROM departamento WHERE Id_Pais = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Pais);
            $stm->execute();    
            
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }    
}
