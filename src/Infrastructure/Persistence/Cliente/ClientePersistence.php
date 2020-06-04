<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\Cliente\ClienteImportado;
use App\Domain\Cliente\ClienteRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class ClientePersistence implements ClienteRepository
{

    private $db = null;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function ListarCliente()
    {
        $sql = "SELECT d.Id_Cliente, d.NIT_CDV, d.Razon_Social, d.Telefono, d.Encargado, d.Ext_Tel_Contacto, d.Direccion, d.Estado_Cliente,
        bv.Id_Barrios_Veredas, IFNULL(bv.Nombre_Barrio_Vereda,'No registrado') Nombre_Barrio_Vereda, sbv.Id_SubTipo_Barrio_Vereda, sbv.SubTipo,m.Id_Municipio,
        IFNULL(m.Nombre_Municipio,'No registrado') Nombre_Municipio, dep.Id_Departamento, IFNULL(dep.Nombre_Departamento,'No registrado') Nombre_Departamento,
        p.Id_Pais, IFNULL(p.Nombre_Pais,'No registrado') Nombre_Pais, dbl.Id_DBL, dbl.Cantidad_Total_Lineas,
        dbl.Valor_Total_Mensual, IFNULL(dbl.Razones,',') Razones, IFNULL(o.Id_Operador,'0') Id_Operador, IFNULL(o.Nombre_Operador,'No especificado') Nombre_Operador, o.Color,
        IFNULL(co.Id_Calificacion_Operador,'0') Id_Calificacion_Operador, IFNULL(co.Calificacion,'No especificado') Calificacion, e.Id_Estado_DBL, e.Estado_DBL,
        CASE WHEN  ISNULL(dbl.Id_Plan_Corporativo) = 0 THEN 'Si' ELSE 'No' END AS Corporativo, IFNULL(pc.Id_Plan_Corporativo,'0') Id_Plan_Corporativo, 
        DATE_FORMAT(pc.Fecha_Inicio,'%e/%b/%Y') Fecha_Inicio, DATE_FORMAT(pc.Fecha_Fin,'%e/%b/%Y') Fecha_Fin,
        pc.Clausula_Permanencia, pc.Descripcion, pc.Estado_Plan_Corporativo,
        IFNULL(ds.Id_Documentos,'0') Id_Documentos, ds.Camara_Comercio, ds.Cedula_RL, ds.Soporte_Ingresos, ds.Detalles_Plan_Corporativo, ds.Oferta
        FROM directorio d LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
        LEFT JOIN municipios m ON(bv.Id_Municipio = m.Id_Municipio)
        LEFT JOIN departamento dep ON(m.Id_Departamento = dep.Id_Departamento)
        LEFT JOIN pais p ON(dep.Id_Pais = p.Id_Pais)
        LEFT JOIN datos_basicos_lineas dbl ON(d.Id_Cliente = dbl.Id_Cliente)
        LEFT JOIN operadores o ON(dbl.Id_Operador = o.Id_Operador)
        LEFT JOIN calificacion_operador co ON(dbl.Id_Calificacion_Operador = co.Id_Calificacion_Operador)
        LEFT JOIN estados_dbl e ON(dbl.Id_Estado_DBL = e.Id_Estado_DBL)
        LEFT JOIN plan_corporativo pc ON(dbl.Id_Plan_Corporativo = pc.Id_Plan_Corporativo)
        LEFT JOIN documentos_soporte ds ON(pc.Id_Documentos = ds.Id_Documentos)
        WHERE dbl.Id_Estado_DBL = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, 3);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {

                // Array con todos los datos del cliente.
                $infoCliente = [];

                // Array sin datos de líneas del cliente.
                $arrayClientes = $stm->fetchAll(PDO::FETCH_ASSOC);

                foreach ($arrayClientes as $cliente) {
                    $sql = " SELECT d.Id_DBL, l.Id_Linea, IFNULL(l.Linea, '0') Linea, l.Minutos, l.Navegacion, l.Mensajes, l.Redes_Sociales, l.Llamadas_Inter,
                    l.Roaming, l.Cargo_Basico, l.Grupo FROM Detalle_Lineas d JOIN Lineas l ON(d.Id_Linea = l.Id_Linea) WHERE d.Id_DBL = ?";
                    try {
                        $stm = $this->db->prepare($sql);
                        $stm->bindValue(1, $cliente['Id_DBL']);
                        $stm->execute();
                        $error = $stm->errorCode();
                        if ($error === '00000') {
                            $DetalleLineas = $stm->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($DetalleLineas)) {

                                $arrayDetalle = array(
                                    'Detalle_Lineas' => $DetalleLineas,
                                );

                                $datosCliente = array_merge($cliente, $arrayDetalle);
                                array_push($infoCliente, $datosCliente);
                            } else {
                                array_push($infoCliente, $cliente);
                            }
                        } else {
                            return $stm->errorInfo();
                        }
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }

                return $infoCliente;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function ObtenerCliente(int $id)
    {
        $sql = "SELECT d.Id_Cliente, d.NIT_CDV, d.Razon_Social, d.Telefono, d.Encargado, d.Ext_Tel_Contacto, d.Direccion, d.Estado_Cliente,
        bv.Id_Barrios_Veredas, bv.Nombre_Barrio_Vereda, sbv.Id_SubTipo_Barrio_Vereda, sbv.SubTipo, m.Id_Municipio, m.Nombre_Municipio,
        dep.Id_Departamento, dep.Nombre_Departamento, p.Id_Pais, p.Nombre_Pais, dbl.Id_DBL, dbl.Cantidad_Total_Lineas, dbl.Valor_Total_Mensual,
        IFNULL(dbl.Razones,',') Razones, IFNULL(o.Id_Operador,'0') Id_Operador, IFNULL(o.Nombre_Operador,'No especificado') Nombre_Operador, o.Color,
        IFNULL(co.Id_Calificacion_Operador,'0') Id_Calificacion_Operador, IFNULL(co.Calificacion,'No especificado') Calificacion, e.Id_Estado_DBL, e.Estado_DBL,
        IFNULL(pc.Id_Plan_Corporativo,'0') Id_Plan_Corporativo, DATE_FORMAT(pc.Fecha_Inicio,'%e/%b/%Y') Fecha_Inicio, DATE_FORMAT(pc.Fecha_Fin,'%e/%b/%Y') Fecha_Fin,
        pc.Clausula_Permanencia, pc.Descripcion, pc.Estado_Plan_Corporativo,
        IFNULL(ds.Id_Documentos,'0') Id_Documentos, ds.Camara_Comercio, ds.Cedula_RL, ds.Soporte_Ingresos, ds.Detalles_Plan_Corporativo, ds.Oferta
        FROM directorio d 
        LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
        LEFT JOIN municipios m ON(bv.Id_Municipio = m.Id_Municipio)
        LEFT JOIN departamento dep ON(m.Id_Departamento = dep.Id_Departamento)
        LEFT JOIN pais p ON(dep.Id_Pais = p.Id_Pais)
        LEFT JOIN datos_basicos_lineas dbl ON(d.Id_Cliente = dbl.Id_Cliente)
        LEFT JOIN operadores o ON(dbl.Id_Operador = o.Id_Operador)
        LEFT JOIN calificacion_operador co ON(dbl.Id_Calificacion_Operador = co.Id_Calificacion_Operador)
        LEFT JOIN estados_dbl e ON(dbl.Id_Estado_DBL = e.Id_Estado_DBL)
        LEFT JOIN plan_corporativo pc ON(dbl.Id_Plan_Corporativo = pc.Id_Plan_Corporativo)
        LEFT JOIN documentos_soporte ds ON(pc.Id_Documentos = ds.Id_Documentos)
        WHERE d.Id_Cliente = ? AND dbl.Id_Estado_DBL = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $id);
            $stm->bindValue(2, 3);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {

                $Info_Cliente = $stm->fetch(PDO::FETCH_ASSOC);

                $sql = " SELECT d.Id_DBL, l.Id_Linea, IFNULL(l.Linea, '0') Linea, l.Minutos, l.Navegacion, l.Mensajes, l.Redes_Sociales, l.Llamadas_Inter,
                l.Roaming, l.Cargo_Basico, l.Grupo FROM Detalle_Lineas d JOIN Lineas l ON(d.Id_Linea = l.Id_Linea) WHERE d.Id_DBL = ?";

                try {
                    $stm = $this->db->prepare($sql);
                    $stm->bindValue(1, $Info_Cliente['Id_DBL']);
                    $stm->execute();
                    $error = $stm->errorCode();
                    if ($error === '00000') {
                        $DetalleLineas = $stm->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($DetalleLineas)) {

                            $arrayDetalle = array(
                                'Detalle_Lineas' => $DetalleLineas,
                            );

                            $Info_Cliente = array_merge($Info_Cliente, $arrayDetalle);
                        }
                        return $Info_Cliente;
                    } else {
                        return $stm->errorInfo();
                    }
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function RegistrarCliente(Cliente $Cliente)
    {
        $sql = "INSERT INTO directorio(NIT_CDV,Razon_Social, Telefono, Encargado,Ext_Tel_Contacto, Direccion, Id_Barrios_Veredas)
        VALUES (?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(2, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(3, $Cliente->__GET("Telefono"));
            $stm->bindValue(4, $Cliente->__GET("Encargado"));
            $stm->bindValue(5, $Cliente->__GET("Ext_Tel_Contacto"));
            $stm->bindValue(6, $Cliente->__GET("Direccion"));
            $stm->bindValue(7, $Cliente->__GET("Id_Barrios_Veredas"));

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

    public function EditarCliente(Cliente $Cliente)
    {

        $sql = "UPDATE directorio SET NIT_CDV = ?, Razon_Social = ?, Telefono = ?,
        Encargado = ?, Ext_Tel_Contacto = ?, Direccion = ?, Id_Barrios_Veredas = ?
        WHERE Id_Cliente = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(2, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(3, $Cliente->__GET("Telefono"));
            $stm->bindValue(4, $Cliente->__GET("Encargado"));
            $stm->bindValue(5, $Cliente->__GET("Ext_Tel_Contacto"));
            $stm->bindValue(6, $Cliente->__GET("Direccion"));
            $stm->bindValue(7, $Cliente->__GET("Id_Barrios_Veredas"));
            $stm->bindValue(8, $Cliente->__GET("Id_Cliente"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ValidarEstadoCliente(int $Id_Cliente)
    {
        $sql = "SELECT Estado_Cliente FROM directorio WHERE Id_Cliente = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Cliente);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return "Error al ValidarEstadoCliente() " + $e->getMessage();
        }
    }

    public function CambiarEstadoCliente(int $Id_Cliente, int $Estado)
    {

        $sql = "UPDATE directorio SET Estado_Cliente = ? WHERE Id_Cliente = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Estado);
            $stm->bindValue(2, $Id_Cliente);

            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return "Error al cambiar estado " + $e->getMessage();
        }
    }

    public function EliminarCliente(int $Id_Cliente)
    {

        $sql = "DELETE FROM directorio WHERE Id_Cliente = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Cliente);

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ValidarEliminarCliente(int $Id_Cliente)
    {

        $sql = "SELECT Id_Cliente FROM directorio WHERE Id_Cliente IN
            (SELECT Id_Cliente from llamadas WHERE Id_cliente = ?) OR Id_Cliente IN
            (SELECT Id_Cliente from visita_interna WHERE Id_cliente = ?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Cliente);
            $stm->bindValue(2, $Id_Cliente);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado()
    {

        $sql = "SELECT Id_Cliente FROM directorio ORDER BY 1 DESC LIMIT 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ImportarClientes(ClienteImportado $Cliente)
    {

        $sql = "INSERT INTO importar_clientes(
        NIT,Razon_Social, Telefono, Encargado,Ext_Tel_Contacto,
        Direccion, Municipio,Tiene_PC,Operador_Actual,Cantidad_Total_Lineas,Valor_Total_Mensual,
        Calificacion,Razones,Fecha_Inicio,Fecha_Fin,Clausula_Permanencia,Descripcion,Estado_Cliente_Importado)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(2, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(3, $Cliente->__GET("Telefono"));
            $stm->bindValue(4, $Cliente->__GET("Encargado"));
            $stm->bindValue(5, $Cliente->__GET("Ext_Tel_Contacto"));
            $stm->bindValue(6, $Cliente->__GET("Direccion"));
            $stm->bindValue(7, $Cliente->__GET("Municipio"));
            $stm->bindValue(8, $Cliente->__GET("Tiene_PC"));
            $stm->bindValue(9, $Cliente->__GET("Operador_Actual"));
            $stm->bindValue(10, $Cliente->__GET("Cantidad_Total_Lineas"));
            $stm->bindValue(11, $Cliente->__GET("Valor_Total_Mensual"));
            $stm->bindValue(12, $Cliente->__GET("Calificacion"));
            $stm->bindValue(13, $Cliente->__GET("Razones"));
            $stm->bindValue(14, $Cliente->__GET("Fecha_Inicio"));
            $stm->bindValue(15, $Cliente->__GET("Fecha_Fin"));
            $stm->bindValue(16, $Cliente->__GET("Clausula_Permanencia"));
            $stm->bindValue(17, $Cliente->__GET("Descripcion"));
            $stm->bindValue(18, $Cliente->__GET("Estado_Cliente_Importado"));

            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function ListarClienteImportados()
    {

        $sql = "SELECT * FROM importar_clientes WHERE Estado_Cliente_Importado = 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public function ValidarUbicacionCliente(?string $Municipio, ?string $Lugar)
    {

        if (!empty($Lugar)) {

            if (!empty($Municipio)) {

                $sql = "SELECT bv.Id_Barrios_Veredas
                FROM municipios m  JOIN barrios_veredas bv ON(m.Id_Municipio = bv.Id_Municipio)
                JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
                WHERE m.Nombre_Municipio = ? AND bv.Nombre_Barrio_Vereda = ?";

                try {
                    $stm = $this->db->prepare($sql);
                    $stm->bindValue(1, $Municipio);
                    $stm->bindValue(2, $Lugar);

                    $stm->execute();

                    $error = $stm->errorCode();
                    if ($error === '00000') {
                        return $stm->fetch(PDO::FETCH_ASSOC);
                    } else {
                        return $stm->errorInfo();
                    }
                } catch (Exception $e) {

                    return $e;
                }
            } else {

                $sql = "SELECT bv.Id_Barrios_Veredas
                FROM municipios m  JOIN barrios_veredas bv ON(m.Id_Municipio = bv.Id_Municipio)
                JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda)
                WHERE bv.Nombre_Barrio_Vereda = ?";

                try {
                    $stm = $this->db->prepare($sql);
                    $stm->bindValue(1, $Lugar);

                    $stm->execute();

                    $error = $stm->errorCode();
                    if ($error === '00000') {
                        return $stm->fetch(PDO::FETCH_ASSOC);
                    } else {
                        return $stm->errorInfo();
                    }
                } catch (Exception $e) {

                    return $e;
                }
            }
        }
    }

    public function ValidarOperadorCliente(string $operador)
    {
        $sql = "SELECT  o.Id_Operador  FROM operadores o WHERE o.Nombre_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $operador);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e;
        }
    }

    public function ValidarCliente(string $texto)
    {
        $sql = "SELECT Id_Cliente FROM directorio WHERE  NIT_CDV = ? OR Razon_Social = ? OR Telefono = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $texto);
            $stm->bindValue(2, $texto);
            $stm->bindValue(3, $texto);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
