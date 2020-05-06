<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cita;

use App\Domain\Cita\Cita;
use App\Domain\Cita\CitaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class CitaPersistence implements CitaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarCita(Cita $Cita)
    {
        $sql = "INSERT INTO citas(Id_Llamada, Encargado_Cita, Ext_Tel_Contacto_Cita, Representante_Legal, 
        Fecha_Cita, Duracion_Verificacion, Direccion, Id_Barrios_Veredas, Lugar_Referencia, Id_Operador, Factibilidad,
        Id_Coordinador, Id_Estado_Cita) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cita->__get("Id_Llamada"));
            $stm->bindValue(2, $Cita->__get("Encargado_Cita"));
            $stm->bindValue(3, $Cita->__get("Ext_Tel_Contacto_Cita"));
            $stm->bindValue(4, $Cita->__get("Representante_Legal"));
            $stm->bindValue(5, $Cita->__get("Fecha_Cita"));
            $stm->bindValue(6, $Cita->__get("Duracion_Verificacion"));
            $stm->bindValue(7, $Cita->__get("Direccion"));
            $stm->bindValue(8, $Cita->__get("Id_Barrios_Veredas"));
            $stm->bindValue(9, $Cita->__get("Lugar_Referencia"));
            $stm->bindValue(10, $Cita->__get("Id_Operador"));
            $stm->bindValue(11, $Cita->__get("Factibilidad"));
            $stm->bindValue(12, $Cita->__get("Id_Coordinador"));
            $stm->bindValue(13, $Cita->__get("Id_Estado_Cita"));

            $respuesta =$stm->execute();

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

    public function ConsultarUltimaCitaRegistrada(){

        $sql = "SELECT Id_Cita FROM citas ORDER BY 1 DESC LIMIT 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
}
