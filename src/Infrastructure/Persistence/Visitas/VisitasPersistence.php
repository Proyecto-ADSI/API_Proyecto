<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Visitas;

use App\Domain\Visitas\Visitas;
use App\Domain\Visitas\VisitasRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class VisitasPersistence implements VisitasRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarVisitas(Visitas $Visitas)
    {
        $sql = "INSERT INTO visitas(Tipo_Visita,Id_Asesor,Id_Cita) VALUES (?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Visitas->__GET("Tipo_Visita"));
            $stm->bindValue(2, $Visitas->__GET("Id_Asesor"));
            $stm->bindValue(3, $Visitas->__GET("Id_Cita"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarVisitas()
    {
        $sql = "SELECT v.Id_Visita,v.Id_Cita,v.Tipo_Visita,u.Usuario,e.Nombre,r.Nombre 'Rol',e.Imagen,e.Email, d.Razon_Social,d.NIT_CDV,d.Encargado,IFNULL(OP.Nombre_Operador,'N/A')'Operador_Actual',IFNULL(OP.Correo_Operador,'N/A')'Correo_OP_Actual',IFNULL(OP.Color,'N/A') 'Color_OP_Actual',IFNULL(OP.Imagen_Operador,'N/A') 'Imagen_OP_Actual',IFNULL(d.Correo,'N/A') 'Correo_Empresa',bb.Nombre_Barrio_Vereda 'Barrio_Empresa',d.Telefono,IFNULL(d.Celular,'N/A') 'Celular_Empresa',c.Encargado_Cita,c.Ext_Tel_Contacto_Cita,c.Fecha_Cita,c.Direccion,b.Nombre_Barrio_Vereda,c.Lugar_Referencia,o.Nombre_Operador 'Operador_Cita',o.Imagen_Operador 'Imagen_OP_Cita',o.Color,IFNULL(o.Correo_Operador,'N/A')'Correo_Operador',c.Id_Estado_Cita,IFNULL(dv.Observacion,'N/A') 'Observacion' FROM visitas v
        INNER JOIN citas c ON (v.Id_Cita = c.Id_Cita)
        INNER JOIN barrios_veredas b ON (c.Id_Barrios_Veredas = b.Id_Barrios_Veredas)
        INNER JOIN operadores o ON (c.Id_Operador = o.Id_Operador)
        INNER JOIN llamadas ll ON (c.Id_Llamada = ll.Id_Llamada)
        INNER JOIN directorio d ON (ll.Id_Cliente = d.Id_Cliente)
        INNER JOIN barrios_veredas bb ON (d.Id_Barrios_Veredas = bb.Id_Barrios_Veredas)
        INNER JOIN usuarios u ON (v.Id_Asesor = u.Id_Usuario)
        INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado)
        INNER JOIN roles r ON (u.Id_Rol = r.Id_Rol)
        LEFT JOIN datos_visita dv ON(v.Id_Datos_Visita = dv.Id_Datos_Visita)
        LEFT JOIN datos_basicos_lineas dbl ON (d.Id_Cliente = dbl.Id_Cliente)
        LEFT JOIN operadores OP ON (dbl.Id_Operador = OP.Id_Operador)";

        try {
            $stm = $this->db->prepare($sql);

            $stm->execute();

            $err = $stm->errorCode();

            if ($err === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }


        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    public function ListarOperadoresVisitas()
    {
        $sql = "SELECT o.Nombre_Operador 'Operador_Cita',o.Color FROM visitas v
        INNER JOIN citas c ON (v.Id_Cita = c.Id_Cita)
        INNER JOIN operadores o ON (c.Id_Operador = o.Id_Operador) GROUP BY o.Nombre_Operador";

        try {
            $stm = $this->db->prepare($sql);

            $stm->execute();

            $err = $stm->errorCode();

            if ($err === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }


        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    public function ListarTiempoFin()
    {
        $sql = "SELECT Duracion_Cita FROM configuracion_sistema";

      try {
        $stm = $this->db->prepare($sql);
        $stm->execute();

        return $stm->fetch(PDO::FETCH_ASSOC);

      } catch (\PDOException $e) {
           $e->getMessage();
      }

    }

    public function ListarVisitas_V2()
    {
        $sql = "SELECT v.Id_Visita,v.Id_Cita,v.Tipo_Visita,u.Usuario,e.Nombre,r.Nombre 'Rol',e.Imagen,e.Email, d.Razon_Social,d.NIT_CDV,d.Encargado,IFNULL(d.Correo,'N/A') 'Correo_Empresa',bb.Nombre_Barrio_Vereda 'Barrio_Empresa',d.Telefono,IFNULL(d.Celular,'N/A') 'Celular_Empresa',c.Encargado_Cita,c.Ext_Tel_Contacto_Cita,c.Fecha_Cita,c.Direccion,b.Nombre_Barrio_Vereda,c.Lugar_Referencia,o.Nombre_Operador 'Operador_Cita',o.Imagen_Operador 'Imagen_OP_Cita',o.Color,IFNULL(o.Correo_Operador,'N/A')'Correo_Operador',c.Id_Estado_Cita,IFNULL(dv.Observacion,'N/A') 'Observacion Visita', IFNULL(dv.Fecha_Visita,'N/A') 'Fecha_Visita', IFNULL(dv.Id_Estado_Visita, 'N/A') 'Estado_Visita' FROM visitas v
        INNER JOIN citas c ON (v.Id_Cita = c.Id_Cita)
        INNER JOIN barrios_veredas b ON (c.Id_Barrios_Veredas = b.Id_Barrios_Veredas)
        INNER JOIN operadores o ON (c.Id_Operador = o.Id_Operador)
        INNER JOIN llamadas ll ON (c.Id_Llamada = ll.Id_Llamada)
        INNER JOIN directorio d ON (ll.Id_Cliente = d.Id_Cliente)
        INNER JOIN barrios_veredas bb ON (d.Id_Barrios_Veredas = bb.Id_Barrios_Veredas)
        INNER JOIN usuarios u ON (v.Id_Asesor = u.Id_Usuario)
        INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado)
        INNER JOIN roles r ON (u.Id_Rol = r.Id_Rol)
        LEFT JOIN datos_visita dv ON(v.Id_Datos_Visita = dv.Id_Datos_Visita)";

        try {
            $stm = $this->db->prepare($sql);

            $stm->execute();

            $err = $stm->errorCode();

            if ($err === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }


        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

}
