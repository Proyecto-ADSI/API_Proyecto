<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Llamada_Programada;

use App\Domain\Llamada_Programada\Llamada_Programada;
use App\Domain\Llamada_Programada\Llamada_ProgramadaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class Llamada_ProgramadaPersistence implements Llamada_ProgramadaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarLlamada_Programada(Llamada_Programada $Llamada_Programada)
    {
        $sql = "INSERT INTO llamadas_programadas(Id_Llamada, Id_Cita, Id_Visita, Fecha_LP) 
        VALUES (?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada_Programada->__GET("Id_Llamada"));
            $stm->bindValue(2, $Llamada_Programada->__GET("Id_Cita"));
            $stm->bindValue(3, $Llamada_Programada->__GET("Id_Visita"));
            $stm->bindValue(4, $Llamada_Programada->__GET("Fecha_LP"));

            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    // public function ConsultarUltimaLlamada_Programada(){
    //     $sql = "SELECT MAX(Id_Llamada_Programada) AS Id_Llamada_Programada FROM Llamada_Programadas ";

    //     try {
    //         $stm = $this->db->prepare($sql);
    //         $stm->execute();

    //         $error = $stm->errorCode();
    //         if ($error === '00000') {

    //             return  $stm->fetch(PDO::FETCH_ASSOC);

    //         } else {
    //             return $stm->errorInfo();
    //         }


    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

}
