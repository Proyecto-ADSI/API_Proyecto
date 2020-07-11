<?php


declare(strict_types=1);


namespace App\Infrastructure\Persistence\DBL;

use App\Domain\DBL\DBL;
use App\Domain\DBL\DBLRepository;
use App\Infrastructure\DataBase;
use PDO;

class DBLPersistence implements DBLRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase;
        $this->db = $database->getConection();
    }



    public function RegistrarDBL(DBL $DBL)
    {

        $sql = "INSERT INTO datos_basicos_lineas(Id_Cliente,Id_Operador,Id_Plan_Corporativo, Cantidad_Total_Lineas, 
        Valor_Total_Mensual, Id_Calificacion_Operador, Razones, Id_Estado_DBL) VALUES (?,?,?,?,?,?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $DBL->__GET("Id_Cliente"));
            $stm->bindValue(2, $DBL->__GET("Id_Operador"));
            $stm->bindValue(3, $DBL->__GET("Id_Plan_Corporativo"));
            $stm->bindValue(4, $DBL->__GET("Cantidad_Total_Lineas"));
            $stm->bindValue(5, $DBL->__GET("Valor_Total_Mensual"));
            $stm->bindValue(6, $DBL->__GET("Id_Calificacion_Operador"));
            $stm->bindValue(7, $DBL->__GET("Razones"));
            $stm->bindValue(8, $DBL->__GET("Estado_DBL"));

            $respuesta = $stm->execute();
            if ($respuesta) {
                return (int) $this->db->lastInsertId();
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarDBL(int $Id_Cliente, int $Estado_DBL)
    {

        $sql = "SELECT dbl.Id_DBL, dbl.Id_Cliente, dbl.Id_Operador, o.Nombre_Operador,  
        IFNULL(dbl.Id_Plan_Corporativo,0) Id_Plan_Corporativo, dbl.Cantidad_Total_Lineas, 
        dbl.Valor_Total_Mensual, dbl.Id_Calificacion_Operador, IFNULL(c.Calificacion,'Sin calificar') Calificacion, 
        IFNULL(dbl.Razones,'Sin especificar') Razones, dbl.Id_Estado_DBL, e.Estado_DBL
        FROM datos_basicos_lineas dbl JOIN Estados_DBL e ON( dbl.Id_Estado_DBL = e.Id_Estado_DBL)
        LEFT JOIN Operadores o ON( dbl.Id_Operador = o.Id_Operador)
        LEFT JOIN Calificacion_Operador c ON(dbl.Id_Calificacion_Operador = c.Id_Calificacion_Operador)
        WHERE dbl.Id_Cliente = ? AND dbl.Id_Estado_DBL = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Cliente);
            $stm->bindValue(2, $Estado_DBL);

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

    public function EditarDBL(DBL $DBL)
    {

        $sql = "UPDATE datos_basicos_lineas SET  Id_Operador = ?, Id_Plan_Corporativo = ?,
        Cantidad_Total_Lineas = ?, Valor_Total_Mensual = ?, Id_Calificacion_Operador = ?,
        Razones = ? WHERE Id_DBL = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $DBL->__GET("Id_Operador"));
            $stm->bindValue(2, $DBL->__GET("Id_Plan_Corporativo"));
            $stm->bindValue(3, $DBL->__GET("Cantidad_Total_Lineas"));
            $stm->bindValue(4, $DBL->__GET("Valor_Total_Mensual"));
            $stm->bindValue(5, $DBL->__GET("Id_Calificacion_Operador"));
            $stm->bindValue(6, $DBL->__GET("Razones"));
            $stm->bindValue(7, $DBL->__GET("Id_DBL"));

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstadoDBL(int $Id_DBL, int $Estado)
    {

        $sql = "UPDATE datos_basicos_lineas SET Estado_DBL = ? WHERE Id_DBL = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Estado);
            $stm->bindValue(2, $Id_DBL);

            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function ELiminarDBL(int $Id_DBL)
    {

        $sql = "DELETE FROM datos_basicos_lineas WHERE Id_DBL = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);

            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado()
    {

        $sql = "SELECT Id_DBL FROM datos_basicos_lineas ORDER BY 1 DESC LIMIT 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarDetalleLineas(int $Id_DBL)
    {
        $sql = " SELECT l.Id_Linea_Movil FROM detalle_lineas d JOIN lineas_moviles l ON(d.Id_Linea_Movil = l.Id_Linea_Movil) WHERE d.Id_DBL = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);

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

    public function ConsultarDetalleLineasFijas(int $Id_DBL)
    {
        $sql = " SELECT l.Id_Linea_Fija FROM detalle_lineas d JOIN lineas_fijas l ON(d.Id_Linea_Fija = l.Id_Linea_Fija) WHERE d.Id_DBL = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);

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
    public function EliminarDetalleLineas(int $Id_DBL)
    {

        $sql = "DELETE FROM detalle_lineas WHERE Id_DBL = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function EliminarDetalleLineasMoviles(int $Id_DBL)
    {

        $sql = "DELETE FROM detalle_lineas WHERE Id_DBL = ? AND Id_Linea_Movil IS NOT NULL";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
