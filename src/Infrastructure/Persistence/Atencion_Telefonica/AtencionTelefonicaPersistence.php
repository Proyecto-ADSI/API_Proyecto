<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Atencion_Telefonica;

use App\Domain\Atencion_Telefonica\AtencionTelefonica;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class AtencionTelefonicaPersistence implements AtencionTelefonicaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarAtencionTelefonica(AtencionTelefonica $AtencionTelefonica)
    {
        $sql = "INSERT INTO atencion_telefonica (Id_Llamada, Medio_Envio,Tiempo_Post_Llamada,Respuesta_Cliente)
        VALUES (?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $AtencionTelefonica->__GET("Id_Llamada"));
            $stm->bindValue(2, $AtencionTelefonica->__GET("Medio_Envio"));
            $stm->bindValue(3, $AtencionTelefonica->__GET("Tiempo_Post_Llamada"));
            $stm->bindValue(4, $AtencionTelefonica->__GET("Respuesta_Cliente"));
            $respuesta = $stm->execute();
            if ($respuesta) {
                return (int) $this->db->lastInsertId();
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarAtencionTelefonica()
    {
        $sql = "SELECT b.Id_Barrios_Veredas, b.Codigo , b.Nombre_Barrio_Vereda, b.Estado,m.Id_Municipio, m.Nombre_Municipio
        AS Municipio, s.Id_SubTipo_Barrio_Vereda, s.SubTipo FROM barrios_veredas b
        INNER JOIN municipios m ON (b.Id_Municipio = m.Id_Municipio)                                         
        INNER JOIN subtipo_barrio_vereda s ON (b.Id_SubTipo_Barrio_Vereda = s.Id_SubTipo_Barrio_Vereda)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado()
    {
        $sql = "SELECT Id_AT FROM atencion_telefonica ORDER BY 1 DESC LIMIT 1";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
