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
        $sql = "INSERT INTO atencion_telefonica (Id_Llamada, Medio_Envio,Tiempo_Post_Llamada, Id_Operador, Respuesta_Cliente)
        VALUES (?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $AtencionTelefonica->__GET("Id_Llamada"));
            $stm->bindValue(2, $AtencionTelefonica->__GET("Medio_Envio"));
            $stm->bindValue(3, $AtencionTelefonica->__GET("Tiempo_Post_Llamada"));
            $stm->bindValue(4, $AtencionTelefonica->__GET("Id_Operador"));
            $stm->bindValue(5, $AtencionTelefonica->__GET("Respuesta_Cliente"));
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
        $sql = "SELECT a.Id_AT, a.Medio_Envio, a.Tiempo_Post_Llamada, IFNULL(a.Respuesta_Cliente,'N/A') Respuesta_Cliente,
        d.Razon_Social, d.Telefono, d.Extension,IFNULL(d.NIT_CDV,'N/A') NIT_CDV, 
        IFNULL(d.Encargado,'N/A') Encargado,
        IFNULL(d.Correo,'N/A') Correo, IFNULL(d.Celular,'N/A') Celular, IFNULL(d.Direccion,'N/A') Direccion,
        IFNULL(bv.Nombre_Barrio_Vereda,'N/A') Nombre_Barrio_Vereda, IFNULL(sbv.SubTipo,'N/A') SubTipo, 
        IFNULL(m.Nombre_Municipio,'N/A') Nombre_Municipio, IFNULL(dep.Nombre_Departamento,'N/A') Nombre_Departamento,
        IFNULL(p.Nombre_Pais,'N/A') Nombre_Pais, u.Id_Usuario, u.Usuario,
        ll.Id_Llamada,ll.Persona_Responde, DATE_FORMAT(ll.Fecha_Llamada,'%e/%b/%Y %h:%i %p') Fecha_Llamada, ll.Duracion_Llamada, 
        UNIX_TIMESTAMP(ll.Fecha_Llamada) Fecha_Filtro, CASE WHEN  ll.Info_Habeas_Data = 1 THEN 'Si' ELSE 'No' END AS Info_Habeas_Data,
        ll.Id_Estado_Llamada, e.Estado_Llamada, ll.Observacion
        FROM atencion_telefonica a 
        JOIN llamadas ll ON(a.Id_Llamada = ll.Id_Llamada)
        JOIN directorio d ON(ll.Id_Cliente = d.Id_Cliente)
        LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
        LEFT JOIN municipios m ON(bv.Id_Municipio = m.Id_Municipio)
        LEFT JOIN departamento dep ON(m.Id_Departamento = dep.Id_Departamento)
        LEFT JOIN pais p ON(dep.Id_Pais = p.Id_Pais)
        JOIN usuarios u ON(ll.Id_Usuario = u.Id_Usuario)
        JOIN estados_llamadas e ON(ll.Id_Estado_Llamada = e.Id_Estado_Llamada)
        ";

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
