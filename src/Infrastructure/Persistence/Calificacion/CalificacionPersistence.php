<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Calificacion;

use App\Domain\Calificacion\Calificacion;
use App\Domain\Calificacion\CalificacionRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class CalificacionPersistence implements CalificacionRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarCalificacion(Calificacion $Calificacion){
        $sql = "INSERT INTO calificacion_operador (Calificacion) VALUES (?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Calificacion->__GET("Calificacion"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarCalificacion(){
        $sql = "SELECT Id_Calificacion_Operador,Calificacion, Estado_Calificacion FROM calificacion_operador";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Calificacion_Operador, int $Estado_Calificacion){
        $sql = "UPDATE calificacion_operador SET Estado_Calificacion= ? WHERE Id_Calificacion_Operador = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado_Calificacion);
          $stm->bindParam(2, $Id_Calificacion_Operador);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosCalificacion($Id_Calificacion_Operador){
        $sql = "SELECT Id_Calificacion_Operador, Calificacion FROM calificacion_operador   
        WHERE Id_Calificacion_Operador = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Calificacion_Operador);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function EditarCalificacion(Calificacion $Calificacion){
        $sql = "UPDATE calificacion_operador SET Calificacion = ?  WHERE Id_Calificacion_Operador = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Calificacion->__GET("Calificacion"));
            $stm->bindValue(2, $Calificacion->__GET("Id_Calificacion_Operador"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function EliminarCalificacion(int $Id_Calificacion){
        $sql = "DELETE FROM calificacion_operador WHERE Id_Calificacion_Operador = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Calificacion);
            $stm->execute();

            $error = $stm->errorCode();
            if($error === '00000'){
                return true;
            }else{
               return $stm->errorInfo();
            }

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function ValidarEliminarCalificacion(int $Id_Calificacion){

        $sql = "SELECT Id_Calificacion_Operador FROM datos_basicos_lineas WHERE Id_Calificacion_Operador = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Calificacion);
            $stm->execute();

            $error = $stm->errorCode();
            if($error === '00000'){
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }else{
               return $stm->errorInfo();
            }

        }catch(Exception $e){

            return $e->getMessage();
        }
    }
}
