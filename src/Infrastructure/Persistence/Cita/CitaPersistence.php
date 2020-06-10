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
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarCita()
    {
        $sql = "SELECT c.Id_Cita, c.Id_Llamada, c.Encargado_Cita, c.Representante_Legal, c.Fecha_Cita, c.Id_Barrios_Veredas, c.Lugar_Referencia,c.Id_Operador,c.Factibilidad,c.Id_Coordinador, c.Id_Estado_Cita,c.Direccion AS Direccion_Cita, esc.Estado_Cita, -- CITAS
        l.Fecha_Llamada,l.Persona_Responde,l.Info_Habeas_Data,l.Id_Estado_Llamada,l.Observacion,esll.Estado_Llamada , -- LLAMADAS
        d.Id_Cliente,d.NIT_CDV,d.Razon_Social,d.Telefono, 
        s.SubTipo,b.Nombre_Barrio_Vereda,m.Nombre_Municipio, de.Nombre_Departamento, 
      
        o.Nombre_Operador, o.Color 'Color_Operador',
        v.Id_Visita,v.Tipo_Visita,
        dV.Id_Datos_Visita ,dV.Fecha_Visita ,dV.Tipo_Venta,dV.Calificacion,dV.Id_Estado_Visita
        from citas c  

        INNER JOIN llamadas l ON(c.Id_Llamada = l.Id_Llamada) 
        INNER JOIN directorio d ON (l.Id_Cliente = d.Id_Cliente)
        INNER JOIN barrios_veredas b ON (b.Id_Barrios_Veredas = c.Id_Barrios_Veredas)
        INNER JOIN subtipo_barrio_vereda s ON (s.Id_SubTipo_Barrio_Vereda = b.Id_SubTipo_Barrio_Vereda)
        INNER JOIN municipios m ON (m.Id_Municipio = b.Id_Municipio)
        INNER JOIN departamento de ON (de.Id_Departamento = m.Id_Departamento)
        INNER JOIN estados_llamadas esll ON (esll.Id_Estado_Llamada = l.Id_Estado_Llamada)
        INNER JOIN Operadores o ON(o.Id_Operador = c.Id_Operador)
        INNER JOIN estados_citas esc ON(esc.Id_Estado_Cita = c.Id_Estado_Cita)
        LEFT JOIN visitas v ON(v.Id_Cita = c.Id_Cita)
        LEFT JOIN datos_visita dV ON(dV.Id_Datos_Visita = v.Id_Datos_Visita)";

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

    public function CambiarEstadoRC(int $Id_Cita, int $Estado)
    {
        $sql = "UPDATE citas SET Id_Estado_Cita = ? WHERE Id_Cita = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Estado);
            $stm->bindParam(2, $Id_Cita);

            $res = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                return $stm->errorInfo();
            }

        } catch (\Exception $e) {
            $e->getMessage();
        }
    }


    public function CambiarEstadoV(int $Id_Cita, int $EstadoV)
    {
        $sql = "UPDATE citas SET Id_Estado_Cita = ? WHERE Id_Cita = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $EstadoV);
            $stm->bindParam(2, $Id_Cita);

            $res = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                return $stm->errorInfo();
            }

        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    
}
