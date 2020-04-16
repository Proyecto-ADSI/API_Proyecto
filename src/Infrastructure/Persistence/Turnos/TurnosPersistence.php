<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Turnos;

use App\Domain\Turnos\Turnos;
use App\Domain\Turnos\TurnosRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class TurnosPersistence implements TurnosRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarTurnos(Turnos $Turnos)
    {
        $sql = "INSERT INTO turnos (Nombre,Inicio,Fin,Estado) VALUES (?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Turnos->__GET("Nombre"));
            $stm->bindValue(2, $Turnos->__GET("Inicio"));
            $stm->bindValue(3, $Turnos->__GET("Fin"));
            $stm->bindValue(4, $Turnos->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarTurno()
    {
        $sql = "SELECT Id_Turno, Nombre, Inicio, Fin, Estado FROM turnos";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function CambiarEstado(int $Id_Turno, int $Estado){
        $sql = "UPDATE turnos SET Estado= ? WHERE Id_Turno = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Turno);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatosTurno($Id_Turno){
        $sql = "SELECT * FROM turnos WHERE Id_Turno = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Turno);
           
           $stm->execute();
           return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarTurno(Turnos $Turnos){
        $sql = "UPDATE turnos SET Nombre = ?, Inicio = ?, Fin = ?  WHERE Id_Turno = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Turnos->__GET("Nombre"));
            $stm->bindValue(2, $Turnos->__GET("Inicio"));
            $stm->bindValue(3, $Turnos->__GET("Fin"));
            $stm->bindValue(4, $Turnos->__GET("Id_Turno"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ValidarEliminarTurno(int $Id_Turno){
        $sql = "SELECT Id_Turno FROM empleados WHERE Id_Turno = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Turno);
            
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);

 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarTurno(int $Id_Turno){
        $sql = "DELETE FROM turnos WHERE Id_Turno = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Turno);
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
}
