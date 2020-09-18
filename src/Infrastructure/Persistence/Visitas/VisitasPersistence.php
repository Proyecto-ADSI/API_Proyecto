<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Visitas;

use App\Domain\Datos_Visita\Datos_Visita;
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
        $sql = "INSERT INTO visitas(Tipo_Visita,Id_Asesor,Id_Cita,Id_Estado_Visita) VALUES (?,?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Visitas->__GET("Tipo_Visita"));
            $stm->bindValue(2, $Visitas->__GET("Id_Asesor"));
            $stm->bindValue(3, $Visitas->__GET("Id_Cita"));
            $stm->bindValue(4, $Visitas->__GET("Id_Estado_Visita"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarVisitas()
    {
        $sql = "SELECT v.Id_Visita,v.Id_Cita,v.Tipo_Visita,u.Usuario,e.Nombre,r.Nombre 'Rol',e.Imagen,e.Email,d.Razon_Social,d.NIT_CDV,
        d.Encargado,OP.Nombre_Operador 'Operador_Actual',IFNULL(OP.Correo_Operador,'N/A')'Correo_OP_Actual',OP.Color 'Color_OP_Actual',
        OP.Imagen_Operador 'Imagen_OP_Actual',IFNULL(d.Correo,'N/A') 'Correo_Empresa',bb.Nombre_Barrio_Vereda 'Barrio_Empresa',
        d.Telefono,IFNULL(d.Celular,'N/A') 'Celular_Empresa',c.Encargado_Cita,c.Ext_Tel_Contacto_Cita,c.Fecha_Cita, c.Fecha_Cita AS Fecha_Fin_Cita,
        c.Direccion,b.Nombre_Barrio_Vereda,c.Lugar_Referencia,o.Nombre_Operador 'Operador_Cita',o.Imagen_Operador 'Imagen_OP_Cita',o.Color,
        IFNULL(o.Correo_Operador,'N/A')'Correo_Operador',c.Id_Estado_Cita,IFNULL(dv.Observacion,'N/A') 'Observacion' 
        FROM visitas v
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
        LEFT JOIN operadores OP ON (dbl.Id_Operador = OP.Id_Operador) GROUP BY d.NIT_CDV";

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

    public function ListarEstados(){
        $sql = "SELECT Id_Estado_Visita, Estado_Visita FROM estados_visita WHERE Id_Estado_Visita = 2 or Id_Estado_Visita = 3 or Id_Estado_Visita = 4";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $E) {
            $E->getMessage();
        }
    }

    public function ListarVisitas_V2()
    {
        $sql = "SELECT v.Id_Visita,v.Id_Cita,v.Tipo_Visita,u.Usuario,e.Nombre,r.Nombre 'Rol',e.Imagen,e.Email, d.Razon_Social,d.NIT_CDV,d.Encargado,IFNULL(d.Correo,'N/A') 'Correo_Empresa',bb.Nombre_Barrio_Vereda 'Barrio_Empresa',d.Telefono,IFNULL(d.Celular,'N/A') 'Celular_Empresa',c.Encargado_Cita,c.Ext_Tel_Contacto_Cita, DATE_FORMAT(c.Fecha_Cita, '%e/%b/%Y %h:%i %p')'Fecha_Cita',c.Direccion,b.Nombre_Barrio_Vereda,c.Lugar_Referencia,o.Nombre_Operador 'Operador_Cita',o.Imagen_Operador 'Imagen_OP_Cita',o.Color,IFNULL(o.Correo_Operador,'N/A')'Correo_Operador',c.Id_Estado_Cita,IFNULL(dv.Observacion,'N/A') 'Observacion_Visita', IFNULL(DATE_FORMAT(dv.Fecha_Visita,'%e/%b/%Y %h:%i %p'),'N/A') 'Fecha_Visita', IFNULL(v.Id_Estado_Visita, 'N/A') 'Estado_Visita', IFNULL(dv.Tipo_Venta,'N/A') 'Tipo_Venta', IFNULL(dv.Sugerencias,'N/A') 'Sugerencias', IFNULL(dv.Calificacion,'N/A') 'Calificacion'  FROM visitas v
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

    public function ObtenerCliente_Visitas(string $NIT)
    {
        $sql = "SELECT v.Id_Visita,d.Id_Cliente, DBL.Id_DBL, Op.Id_Operador ,DBL.Valor_Total_Mensual, d.Razon_Social, d.Telefono,v.Id_Estado_Visita,
        o.Nombre_Operador 'Operador_Actual', o.Color 'Color_Operador_Actual', Op.Nombre_Operador 'Operador_Cita',Op.Color 'Color_Operador_Cita', Edbl.Estado_DBL FROM visitas v

        INNER JOIN citas c ON (v.Id_Cita = c.Id_Cita)
        INNER JOIN operadores Op ON (c.Id_Operador = Op.Id_Operador)
        INNER JOIN llamadas ll ON (c.Id_Llamada = ll.Id_Llamada)
        INNER JOIN directorio d ON (ll.Id_Cliente = d.Id_Cliente) 
        INNER JOIN datos_basicos_lineas DBL ON (d.Id_Cliente = DBL.Id_Cliente)
        INNER JOIN estados_dbl Edbl ON (DBL.Id_Estado_DBL = Edbl.Id_Estado_DBL)
        INNER JOIN operadores o ON (DBL.Id_Operador = o.Id_Operador)
        WHERE d.NIT_CDV = '".$NIT."'";

        try {
            $stm = $this->db->prepare($sql);

            $stm->execute();

            $err = $stm->errorCode();

            if ($err === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }

        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    public function ModificarVisita(int $Id, int $Estado, int $Id_Datos_Visita)
    {
        $sql = "UPDATE visitas SET Id_Estado_Visita = ?, Id_Datos_Visita = ? WHERE Id_Visita = ? ";

        try {

           $stm = $this->db->prepare($sql);
           $stm->bindParam(1,$Estado);
           $stm->bindParam(2,$Id_Datos_Visita);
           $stm->bindParam(3,$Id);

           return $stm->execute();

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarDatosVisita(Datos_Visita $Datos_Visita)
    {
        $sql = "INSERT INTO datos_visita(Tipo_Venta,Calificacion,Sugerencias,Observacion) VALUES (?,?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Datos_Visita->__GET("Tipo_Venta"));
            $stm->bindValue(2,$Datos_Visita->__GET("Calificacion"));
            $stm->bindValue(3,$Datos_Visita->__GET("Sugerencias"));
            $stm->bindValue(4,$Datos_Visita->__GET("Observacion"));

            $stm->execute();

            return (int) $this->db->lastInsertId();
            
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id, int $Estado)
    {
        $sql = "UPDATE visitas SET Id_Estado_Visita = ? WHERE Id_Visita = ?";

        try {
            $stm = $this->db->prepare($sql);

            $stm->bindValue(1,$Estado);
            $stm->bindValue(2,$Id);

            return $stm->execute();

        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }
}
