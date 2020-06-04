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

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarLlamada(Llamada $Llamada)
    {
        $sql = "INSERT INTO llamadas(Id_Usuario,Id_Cliente, Persona_Responde, Duracion_Llamada,
        Info_Habeas_Data,Observacion,Id_Estado_Llamada)
        VALUES (?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada->__GET("Id_Usuario"));
            $stm->bindValue(2, $Llamada->__GET("Id_Cliente"));
            $stm->bindValue(3, $Llamada->__GET("Persona_Responde"));
            $stm->bindValue(4, $Llamada->__GET("Duracion_Llamada"));
            $stm->bindValue(5, $Llamada->__GET("Info_Habeas_Data"));
            $stm->bindValue(6, $Llamada->__GET("Observacion"));
            $stm->bindValue(7, $Llamada->__GET("Id_Estado_Llamada"));

            return $stm->execute();
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function ListarLlamadas()
    {

        $sql = "SELECT d.Razon_Social, d.Telefono, d.NIT_CDV, d.Encargado, d.Ext_Tel_Contacto, IFNULL(d.Direccion,'No registrado') Direccion,
        IFNULL(bv.Nombre_Barrio_Vereda,'No registrado') Nombre_Barrio_Vereda, IFNULL(sbv.SubTipo,'No registrado') SubTipo, 
        IFNULL(m.Nombre_Municipio,'No registrado') Nombre_Municipio, IFNULL(dep.Nombre_Departamento,'No registrado') Nombre_Departamento,
        IFNULL(p.Nombre_Pais,'No registrado') Nombre_Pais, u.Id_Usuario, u.Usuario,
        ll.Id_Llamada,ll.Persona_Responde, DATE_FORMAT(ll.Fecha_Llamada,'%e/%b/%Y %h:%i %p') Fecha_Llamada, ll.Duracion_Llamada,
        CASE WHEN  ll.Info_Habeas_Data = 1 THEN 'Si' ELSE 'No' END AS Info_Habeas_Data, ll.Id_Estado_Llamada, e.Estado_Llamada, ll.Observacion
        FROM llamadas ll 
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

            $error = $stm->errorCode();
            if ($error === '00000') {

                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimaLlamada()
    {
        $sql = "SELECT MAX(Id_Llamada) AS Id_Llamada FROM llamadas ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {

                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
