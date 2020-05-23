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

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }


    public function ListarCliente(){
        $sql = "SELECT d.Id_Cliente, d.NIT_CDV, d.Razon_Social, d.Telefono, o.Nombre_Operador AS Operador,
        CASE WHEN  ISNULL(dbl.Id_Plan_Corporativo) = 0 THEN 'Si' 
        ELSE 'No' END AS Corporativo, m.Nombre_Municipio AS Municipio, d.Estado_Cliente 
        FROM directorio d 
        INNER JOIN datos_basicos_lineas dbl ON(d.Id_Cliente= dbl.Id_Cliente) 
        INNER JOIN operadores o ON(dbl.Id_Operador = o.Id_Operador)
        LEFT JOIN barrios_veredas bv ON(d.Id_Barrios_Veredas = bv.Id_Barrios_Veredas)
        LEFT JOIN municipios m ON (bv.Id_Municipio = m.Id_Municipio)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerCliente(int $id){
        $sql = "SELECT * FROM directorio WHERE Id_Cliente = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $id);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }


    public function RegistrarCliente(Cliente $Cliente){
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

    public function EditarCliente(Cliente $Cliente){

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

    public function ValidarEstadoCliente(int $Id_Cliente){
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


    public function CambiarEstadoCliente(int $Id_Cliente, int $Estado){
        
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


    public function EliminarCliente(int $Id_Cliente){

        $sql = "DELETE FROM directorio WHERE Id_Cliente = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Cliente);

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ValidarEliminarCliente(int $Id_Cliente){

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
                return  $stm->errorInfo();
            }
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function ListarClienteImportados(){

        $sql = "SELECT * FROM importar_clientes WHERE Estado_Cliente_Importado = 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }


    public function ValidarUbicacionCliente(?string $Municipio, ?string $Lugar){

        if (!empty($Lugar)) {

            if (!empty($Municipio)) {

                $sql = "SELECT bv.Id_Barrios_Veredas 
                FROM municipios m  JOIN barrios_veredas bv ON(m.Id_Municipio = bv.Id_Municipio) 
                JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda) 
                WHERE m.Nombre_Municipio = ? AND bv.Nombre_Barrio_Vereda = ?";
    
                try {
                    $stm = $this->db->prepare($sql);
                    $stm->bindValue(1,$Municipio);
                    $stm->bindValue(2,$Lugar);
    
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

            }else{

                $sql = "SELECT bv.Id_Barrios_Veredas 
                FROM municipios m  JOIN barrios_veredas bv ON(m.Id_Municipio = bv.Id_Municipio) 
                JOIN subtipo_barrio_vereda sbv ON(bv.Id_SubTipo_Barrio_Vereda = sbv.Id_SubTipo_Barrio_Vereda) 
                WHERE bv.Nombre_Barrio_Vereda = ?";
    
                try {
                    $stm = $this->db->prepare($sql);
                    $stm->bindValue(1,$Lugar);
    
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

    public function ValidarOperadorCliente(string $operador){   
        $sql = "SELECT  o.Id_Operador  FROM operadores o WHERE o.Nombre_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$operador);
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
