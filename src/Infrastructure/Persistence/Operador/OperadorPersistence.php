<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Operador;

use App\Domain\Operador\Operador;
use App\Domain\Operador\OperadorRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class OperadorPersistence implements OperadorRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarOperador(Operador $Operador)
    {
        $sql = "INSERT INTO operadores (Nombre_Operador,Color,Genera_Oferta,Correo_Operador,Contrasena_Operador,Imagen_Operador,Estado_Operador) VALUES (?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Operador->__GET("Nombre"));
            $stm->bindValue(2, $Operador->__GET("Color"));
            $stm->bindValue(3, $Operador->__GET("Genera_Oferta"));
            $stm->bindValue(4, $Operador->__GET("Correo_Operador"));
            $stm->bindValue(5, $Operador->__GET("Contrasena_Operador"));
            $stm->bindValue(6, $Operador->__GET("Imagen_Operador"));
            $stm->bindValue(7, $Operador->__GET("Estado"));

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

    public function ListarOperador()
    {
        $sql = "SELECT Id_Operador, Nombre_Operador, Color ,
        CASE WHEN  Genera_Oferta = 1 THEN 'Si' ELSE 'No' END AS Genera_Oferta,
        IFNULL(Correo_Operador,'N/A') Correo_Operador,
        Imagen_Operador,Estado_Operador FROM operadores ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarOperadorOferta()
    {
        $sql = "SELECT Id_Operador, Nombre_Operador, Color ,
        CASE WHEN  Genera_Oferta = 1 THEN 'Si' ELSE 'No' END AS Genera_Oferta,
        IFNULL(Correo_Operador,'N/A') Correo_Operador,
        Imagen_Operador,Estado_Operador FROM operadores WHERE Genera_Oferta = 1";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarOperadoresFiltro(string $texto){
        $sql = "SELECT Id_Operador, Nombre_Operador FROM operadores ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Operador, int $Estado)
    {
        $sql = "UPDATE operadores SET Estado_Operador= ? WHERE Id_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Estado);
            $stm->bindParam(2, $Id_Operador);

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosOperador($Id_Operador)
    {
        $sql = "SELECT Id_Operador, Nombre_Operador, Color ,
        CASE WHEN  Genera_Oferta = 1 THEN 'Si' ELSE 'No' END AS Genera_Oferta,
        IFNULL(Correo_Operador,'N/A') Correo_Operador, IFNULL(Contrasena_Operador,'N/A') Contrasena_Operador,
        Imagen_Operador,Estado_Operador FROM operadores WHERE Id_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Operador);

            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarOperador(Operador $Operador)
    {
        $sql = "UPDATE operadores SET Nombre_Operador = ? , Color = ?, Genera_Oferta = ?, Correo_Operador = ?, 
        Contrasena_Operador = ?, Imagen_Operador = ? WHERE Id_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Operador->__GET("Nombre"));
            $stm->bindValue(2, $Operador->__GET("Color"));
            $stm->bindValue(3, $Operador->__GET("Genera_Oferta"));
            $stm->bindValue(4, $Operador->__GET("Correo_Operador"));
            $stm->bindValue(5, $Operador->__GET("Contrasena_Operador"));
            $stm->bindValue(6, $Operador->__GET("Imagen_Operador"));
            $stm->bindValue(7, $Operador->__GET("Id_Operador"));

            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ValidarOperadorEliminar(int $Id_Operador)
    {
        $sql = "SELECT Id_Operador FROM operadores WHERE Id_Operador IN (SELECT Id_Operador from usuarios WHERE Id_Operador = ?)
         OR Id_Operador IN (SELECT Id_Operador from datos_basicos_lineas WHERE Id_Operador = ?)
         OR Id_Operador IN (SELECT Id_Operador from citas WHERE Id_Operador = ?)
         OR Id_Operador IN (SELECT Id_Operador from operadores_asesores WHERE Id_Operador = ?)
         ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Operador);
            $stm->bindValue(2, $Id_Operador);
            $stm->bindValue(3, $Id_Operador);
            $stm->bindValue(4, $Id_Operador);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarOperador(int $Id_Operador)
    {
        $sql = "DELETE FROM operadores WHERE Id_Operador = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Operador);

            return $stm->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
