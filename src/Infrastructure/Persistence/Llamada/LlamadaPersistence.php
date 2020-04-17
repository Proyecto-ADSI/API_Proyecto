<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Llamada;

use App\Domain\Llamada\Llamada;
use App\Domain\Llamada\LlamadaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class LlamadaPersistence implements LlamadaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarLlamada(Llamada $Llamada)
    {
        $sql = "INSERT INTO llamadas(Id_Usuario,Id_Cliente, Persona_Responde, Fecha_Llamada,
        Info_Habeas_Data,Observacion,Id_Estado_Llamada) 
        VALUES (?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada->__GET("Id_Usuario"));
            $stm->bindValue(2, $Llamada->__GET("Id_Cliente"));
            $stm->bindValue(3, $Llamada->__GET("Persona_Responde"));
            $stm->bindValue(4, $Llamada->__GET("Fecha_Llamada"));
            $stm->bindValue(5, $Llamada->__GET("Info_Habeas_Data"));
            $stm->bindValue(6, $Llamada->__GET("Observacion"));
            $stm->bindValue(7, $Llamada->__GET("Id_Estado_Llamada"));

            return $stm->execute();
            
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function EditarLlamada(Llamada $Llamada){

        $sql ="UPDATE llamadas SET Persona_Responde = ?, Fecha_Llamada = ?,Info_Habeas_Data = ?, 
        Observacion = ?, Id_Estado_Llamada = ? WHERE Id_Llamada = ?";
            
        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada->__GET("Persona_Responde"));
            $stm->bindValue(2, $Llamada->__GET("Fecha_Llamada"));
            $stm->bindValue(3, $Llamada->__GET("Info_Habeas_Data"));
            $stm->bindValue(4, $Llamada->__GET("Observacion"));
            $stm->bindValue(5, $Llamada->__GET("Id_Estado_Llamada"));
            $stm->bindValue(6, $Llamada->__GET("Id_Llamada"));
      
            return $stm->execute();             
        }
        catch(Exception $e){

            return $e->getMessage();

        }
    }
    
}
