<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Razones;

use App\Domain\Razones\Razones;
use App\Domain\Razones\RazonesRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class RazonesPersistence implements RazonesRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarRazones(Razones $Razones){
        $sql = "INSERT INTO razones (Razon,Tipo_Razon) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Razones->__GET("Razon"));
            $stm->bindValue(2, $Razones->__GET("Tipo_Razon"));

            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarRazones(){
        $sql = "SELECT Id_Razon_Calificacion,Razon,Tipo_Razon FROM razones";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarRazonesTipo(string $Tipo){
        $sql = "SELECT Id_Razon_Calificacion,Razon,Tipo_Razon FROM razones WHERE Tipo_Razon = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Tipo);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosRazones($Id_Razon_Calificacion){
        $sql = "SELECT Id_Razon_Calificacion, Razon, Tipo_Razon FROM razones   
        WHERE Id_Razon_Calificacion = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Razon_Calificacion);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarRazones(Razones $Razones){
        $sql = "UPDATE razones SET Razon = ?, Tipo_Razon = ?  WHERE Id_Razon_Calificacion = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Razones->__GET("Razon"));
            $stm->bindValue(2, $Razones->__GET("Tipo_Razon"));
            $stm->bindValue(3, $Razones->__GET("Id_Razon_Calificacion"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function EliminarRazones(int $Id_Razones){
        $sql = "DELETE FROM razones WHERE Id_Razon_Calificacion = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Razones);
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
}
