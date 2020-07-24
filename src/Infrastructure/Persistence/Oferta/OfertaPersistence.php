<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Oferta;

use App\Domain\Oferta\Oferta;
use App\Domain\Oferta\Oferta_P;
use App\Domain\Oferta\OfertaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class OfertaPersistence implements OfertaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarOferta(Oferta $Oferta)
    {
        $sql = "INSERT INTO ofertas 
        (Id_AT, Id_Visita,Nombre_Cliente,Mensaje_Superior,Tipo_Oferta,Respuesta_Cliente, Fecha_Activacion,Id_Estado_Oferta)
        VALUES (?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Oferta->__GET("Id_AT"));
            $stm->bindValue(2, $Oferta->__GET("Id_Visita"));
            $stm->bindValue(3, $Oferta->__GET("Nombre_Cliente"));
            $stm->bindValue(4, $Oferta->__GET("Mensaje_Superior"));
            $stm->bindValue(5, $Oferta->__GET("Tipo_Oferta"));
            $stm->bindValue(6, $Oferta->__GET("Respuesta_Cliente"));
            $stm->bindValue(7, $Oferta->__GET("Fecha_Activacion"));
            $stm->bindValue(8, $Oferta->__GET("Id_Estado_Oferta"));
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

    public function ListarOfertas()
    {
        $sql = "SELECT o.Id_Oferta, o.Id_AT, o.Id_Visita, o.Id_Estado_Oferta, eo.Estado_Oferta,
        IFNULL(o.Nombre_Cliente,'N/A') Nombre_Cliente, o.Mensaje_Superior, o.Tipo_Oferta, 
        IFNULL(o.Respuesta_Cliente,'N/A') Respuesta_Cliente, IFNULL(o.Fecha_Activacion,'N/A') Fecha_Activacion
        FROM ofertas o 
        JOIN estados_oferta eo ON(eo.Id_Estado_Oferta = o.Id_Estado_Oferta)
        ";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarPropuestas(int $Cantidad_Lineas, int $Id_Linea_Movil)
    {
        $sql = "INSERT INTO propuestas (Cantidad_Lineas, Id_Linea_Movil) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cantidad_Lineas);
            $stm->bindValue(2, $Id_Linea_Movil);
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

    public function RegistrarOfertaEstandar(int $Id_Oferta, int $Id_Propuesta)
    {
        $sql = "INSERT INTO oferta_estandar (Id_Oferta, Id_Propuesta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Oferta);
            $stm->bindValue(2, $Id_Propuesta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarOfertaPersonalizada(Oferta_P $Oferta_P)
    {
        $sql = "INSERT INTO oferta_personalizada (
            Id_Oferta, 
            Id_Corporativo_Anterior, 
            Id_Corporativo_Actual, 
            Basico_Neto_Operador1, 
            Basico_Neto_Operador2,
            Valor_Neto_Operador1, 
            Valor_Bruto_Operador2, 
            Bono_Activacion, 
            Valor_Neto_Operador2, 
            Total_Ahorro, 
            Reduccion_Anual,
            Valor_Mes_Promedio,
            Ahorro_Mensual_Promedio
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Oferta_P->__get("Id_Oferta"));
            $stm->bindValue(2, $Oferta_P->__get("Id_Corporativo_Anterior"));
            $stm->bindValue(3, $Oferta_P->__get("Id_Corporativo_Actual"));
            $stm->bindValue(4, $Oferta_P->__get("Basico_Neto_Operador1"));
            $stm->bindValue(5, $Oferta_P->__get("Basico_Neto_Operador2"));
            $stm->bindValue(6, $Oferta_P->__get("Valor_Neto_Operador1"));
            $stm->bindValue(7, $Oferta_P->__get("Valor_Bruto_Operador2"));
            $stm->bindValue(8, $Oferta_P->__get("Bono_Activacion"));
            $stm->bindValue(9, $Oferta_P->__get("Valor_Neto_Operador2"));
            $stm->bindValue(10, $Oferta_P->__get("Total_Ahorro"));
            $stm->bindValue(11, $Oferta_P->__get("Reduccion_Anual"));
            $stm->bindValue(12, $Oferta_P->__get("Valor_Mes_Promedio"));
            $stm->bindValue(13, $Oferta_P->__get("Ahorro_Mensual_Promedio"));
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarDBLAnterior(int $Id_DBL)
    {
        $sql = "INSERT INTO corporativos_anteriores (Id_DBL) VALUES (?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
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
    public function RegistrarDBLActual(int $Id_DBL)
    {
        $sql = "INSERT INTO corporativos_Actuales (Id_DBL) VALUES (?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
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

    public function RegistrarAclaraciones(int $Id_Oferta, string $texto)
    {
        $sql = "INSERT INTO aclaraciones (Aclaracion, Id_Oferta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $texto);
            $stm->bindValue(2, $Id_Oferta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarNotas(int $Id_Oferta, string $texto)
    {
        $sql = "INSERT INTO notas (Nota, Id_Oferta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $texto);
            $stm->bindValue(2, $Id_Oferta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ObtenerOfertaEstandar(int $Id_Oferta)
    {
        $sql = "SELECT oe.Id_OE, oe.Id_Oferta, oe.Id_Propuesta, p.Id_Propuesta, p.Cantidad_Lineas,
        IFNULL(lm.Minutos,'N/A') Minutos, 
        IFNULL(lm.Navegacion,'N/A') Navegacion, IFNULL(lm.Mensajes,'N/A') Mensajes, 
        IFNULL(lm.Servicios_Ilimitados,',') Servicios_Ilimitados,
        IFNULL(lm.Minutos_LDI,',') Minutos_LDI, IFNULL(lm.Cantidad_LDI,'N/A') Cantidad_LDI,
        IFNULL(lm.Servicios_Adicionales,',') Servicios_Adicionales, lm.Cargo_Basico
        FROM oferta_estandar oe 
        JOIN propuestas p ON(oe.Id_Propuesta = p.Id_Propuesta)
        JOIN lineas_moviles lm ON(p.Id_Linea_Movil = lm.Id_Linea_Movil)
        WHERE oe.Id_Oferta = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Oferta);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerOfertaPersonalizada(int $Id_Oferta)
    {
        $sql = "SELECT op.Id_op, op.Id_Oferta, cant.Id_DBL DBL_Anterior, cact.Id_DBL DBL_Actual, 
        op.Basico_Neto_Operador1, op.Basico_Neto_Operador2, op.Valor_Neto_Operador1, op.Valor_Bruto_Operador2, 
        op.Bono_Activacion, op.Valor_Neto_Operador2, op.Total_Ahorro, op.Reduccion_Anual, op.Valor_Mes_Promedio, 
        op.Ahorro_Mensual_Promedio
        FROM oferta_personalizada op
        JOIN corporativos_anteriores cant ON(cant.Id_Corporativo_Anterior = op.Id_Corporativo_Anterior)
        JOIN corporativos_actuales cact ON(cact.Id_Corporativo_Actual = op.Id_Corporativo_Actual)
        WHERE op.Id_Oferta = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Oferta);
            $res = $stm->execute();
            if ($res) {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerAclaraciones(int $Id_Oferta)
    {
        $sql = "SELECT Aclaracion FROM aclaraciones WHERE Id_Oferta = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Oferta);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerNotas(int $Id_Oferta)
    {
        $sql = "SELECT Nota FROM Notas WHERE Id_Oferta = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Oferta);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerInfoOfertaAT(int $Id_AT)
    {

        $sql = "SELECT a.Id_AT, a.Medio_Envio, a.Tiempo_Post_Llamada, op.Id_Operador Id_Operador_O , op.Nombre_Operador Nombre_Operador_O,
        op.Color Color_O, d.Razon_Social, d.Telefono, d.Extension,
        IFNULL(d.NIT_CDV,'N/A') NIT_CDV, IFNULL(d.Encargado,'N/A') Encargado,
        IFNULL(d.Correo,'N/A') Correo, IFNULL(d.Celular,'N/A') Celular, IFNULL(d.Direccion,'N/A') Direccion,
        IFNULL(bv.Nombre_Barrio_Vereda,'N/A') Nombre_Barrio_Vereda, IFNULL(sbv.SubTipo,'N/A') SubTipo, 
        IFNULL(m.Nombre_Municipio,'N/A') Nombre_Municipio, IFNULL(dep.Nombre_Departamento,'N/A') Nombre_Departamento,
        IFNULL(p.Nombre_Pais,'N/A') Nombre_Pais, u.Id_Usuario, u.Usuario, em.Imagen, r.Nombre Rol,
        ll.Id_Llamada,ll.Persona_Responde, DATE_FORMAT(ll.Fecha_Llamada,'%e/%b/%Y %h:%i %p') Fecha_Llamada, ll.Duracion_Llamada, 
        UNIX_TIMESTAMP(ll.Fecha_Llamada) Fecha_Filtro, CASE WHEN  ll.Info_Habeas_Data = 1 THEN 'Si' ELSE 'No' END AS Info_Habeas_Data,
        ll.Id_Estado_Llamada, e.Estado_Llamada, ll.Observacion
        FROM ofertas o
        JOIN atencion_telefonica a ON (a.Id_AT = o.Id_AT)
        JOIN operadores op ON(a.Id_Operador = op.Id_Operador)
        JOIN llamadas ll ON(a.Id_Llamada = ll.Id_Llamada)
        JOIN directorio d ON(ll.Id_Cliente = d.Id_Cliente)
        LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
        LEFT JOIN municipios m ON(bv.Id_Municipio = m.Id_Municipio)
        LEFT JOIN departamento dep ON(m.Id_Departamento = dep.Id_Departamento)
        LEFT JOIN pais p ON(dep.Id_Pais = p.Id_Pais)
        JOIN usuarios u ON(ll.Id_Usuario = u.Id_Usuario)
        JOIN empleados em ON(em.Id_Empleado = u.Id_Empleado)
        JOIN roles r ON(r.Id_Rol = u.Id_Rol)
        JOIN estados_llamadas e ON(ll.Id_Estado_Llamada = e.Id_Estado_Llamada)
        WHERE o.Id_AT = ?
        ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_AT);
            $res = $stm->execute();
            if ($res) {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerInfoOfertaVisita(int $Id_Visita)
    {

        $sql = "SELECT a.Id_AT, a.Medio_Envio, a.Tiempo_Post_Llamada, o.Id_Operador, o.Nombre_Operador, o.Color,
        d.Razon_Social, d.Telefono, d.Extension,IFNULL(d.NIT_CDV,'N/A') NIT_CDV, 
        IFNULL(d.Encargado,'N/A') Encargado,
        IFNULL(d.Correo,'N/A') Correo, IFNULL(d.Celular,'N/A') Celular, IFNULL(d.Direccion,'N/A') Direccion,
        IFNULL(bv.Nombre_Barrio_Vereda,'N/A') Nombre_Barrio_Vereda, IFNULL(sbv.SubTipo,'N/A') SubTipo, 
        IFNULL(m.Nombre_Municipio,'N/A') Nombre_Municipio, IFNULL(dep.Nombre_Departamento,'N/A') Nombre_Departamento,
        IFNULL(p.Nombre_Pais,'N/A') Nombre_Pais, u.Id_Usuario, u.Usuario, em.Imagen, r.Nombre Rol,
        ll.Id_Llamada,ll.Persona_Responde, DATE_FORMAT(ll.Fecha_Llamada,'%e/%b/%Y %h:%i %p') Fecha_Llamada, ll.Duracion_Llamada, 
        UNIX_TIMESTAMP(ll.Fecha_Llamada) Fecha_Filtro, CASE WHEN  ll.Info_Habeas_Data = 1 THEN 'Si' ELSE 'No' END AS Info_Habeas_Data,
        ll.Id_Estado_Llamada, e.Estado_Llamada, ll.Observacion
        FROM ofertas po
        JOIN atencion_telefonica a ON (a.Id_AT = po.Id_AT)
        JOIN operadores o ON(a.Id_Operador = op.Id_Operador)
        JOIN llamadas ll ON(a.Id_Llamada = ll.Id_Llamada)
        JOIN directorio d ON(ll.Id_Cliente = d.Id_Cliente)
        LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
        LEFT JOIN municipios m ON(bv.Id_Municipio = m.Id_Municipio)
        LEFT JOIN departamento dep ON(m.Id_Departamento = dep.Id_Departamento)
        LEFT JOIN pais p ON(dep.Id_Pais = p.Id_Pais)
        JOIN usuarios u ON(ll.Id_Usuario = u.Id_Usuario)
        JOIN empleados em ON(em.Id_Empleado = u.Id_Empleado)
        JOIN roles r ON(r.Id_Rol = u.Id_Rol)
        JOIN estados_llamadas e ON(ll.Id_Estado_Llamada = e.Id_Estado_Llamada)
        WHERE o.Id_AT = ?
        ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Visita);
            $res = $stm->execute();
            if ($res) {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarAccionOferta(int $Id_Usuario, int $Id_Oferta, int $Id_Estado_Oferta, string $Mensaje)
    {
        $sql = "INSERT INTO acciones_oferta (Id_Usuario, Id_Oferta, Id_Estado_Oferta, Mensaje ) VALUES (?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Id_Oferta);
            $stm->bindValue(3, $Id_Estado_Oferta);
            $stm->bindValue(4, $Mensaje);
            $respuesta = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarAccionesOferta(int $Id_Oferta)
    {
        $sql = "SELECT u.Id_Usuario, u.Usuario, em.Imagen, r.Nombre Rol, eo.Id_Estado_Oferta, eo.Estado_Oferta, ac.Mensaje,
        DATE_FORMAT(ac.Fecha_Accion,'%e/%b/%Y %h:%i %p') Fecha_Accion, UNIX_TIMESTAMP(ac.Fecha_Accion) Fecha_Filtro
        FROM acciones_oferta ac 
        JOIN usuarios u ON(ac.Id_Usuario = u.Id_Usuario)
        JOIN empleados em ON(em.Id_Empleado = u.Id_Empleado)
        JOIN roles r ON(r.Id_Rol = u.Id_Rol)
        JOIN estados_oferta eo ON(ac.Id_Estado_Oferta = eo.Id_Estado_Oferta)
        WHERE Id_Oferta = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Oferta);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstadoOferta(int $Id_Oferta, int $Estado)
    {
        $sql = "UPDATE ofertas SET Id_Estado_Oferta = ? WHERE Id_Oferta = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Estado);
            $stm->bindParam(2, $Id_Oferta);
            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
