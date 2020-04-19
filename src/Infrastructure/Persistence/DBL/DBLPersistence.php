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

        $sql = "INSERT INTO Datos_Basicos_Lineas(Id_Cliente,Id_Operador,Id_Plan_Corporativo, Cantidad_Total_Lineas, 
        Valor_Total_Mensual, Id_Calificacion_Operador, Razones) VALUES (?,?,?,?,?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $DBL->__GET("Id_Cliente"));
            $stm->bindValue(2, $DBL->__GET("Id_Operador"));
            $stm->bindValue(3, $DBL->__GET("Id_Plan_Corporativo"));
            $stm->bindValue(4, $DBL->__GET("Cantidad_Total_Lineas"));
            $stm->bindValue(5, $DBL->__GET("Valor_Total_Mensual"));
            $stm->bindValue(6, $DBL->__GET("Id_Calificacion_Operador"));
            $stm->bindValue(7, $DBL->__GET("Razones"));


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

    public function ListarDBL(int $Id_Cliente, int $Estado_DBL)
    {

        $sql = "SELECT dbl.Id_DBL, dbl.Id_Cliente, dbl.Id_Operador, o.Nombre_Operador,  
        IFNULL(dbl.Id_Plan_Corporativo,0) Id_Plan_Corporativo, dbl.Cantidad_Total_Lineas, 
        dbl.Valor_Total_Mensual, dbl.Id_Calificacion_Operador, IFNULL(c.Calificacion,'Sin calificar') Calificacion, 
        IFNULL(dbl.Razones,'Sin especificar') Razones, dbl.Id_Estado_DBL, e.Estado_DBL
        FROM Datos_Basicos_Lineas dbl JOIN Estados_DBL e ON( dbl.Id_Estado_DBL = e.Id_Estado_DBL)
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

        $sql = "UPDATE Datos_Basicos_lineas SET  Id_Operador = ?, Id_Plan_Corporativo = ?,
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

        $sql = "UPDATE Datos_Basicos_Lineas SET Estado_DBL = ? WHERE Id_DBL = ?";

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

        $sql = "DELETE FROM Datos_Basicos_Lineas WHERE Id_DBL = ?";

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

        $sql = "SELECT Id_DBL FROM Datos_Basicos_Lineas ORDER BY 1 DESC LIMIT 1";

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

        $sql = " SELECT d.Id_DBL, l.Id_Linea, IFNULL(l.Linea, '0') Linea, l.Minutos, l.Navegacion, l.Mensajes, l.Redes_Sociales, l.Llamadas_Inter,
        l.Roaming, l.Cargo_Basico, l.Grupo FROM Detalle_Lineas d JOIN Lineas l ON(d.Id_Linea = l.Id_Linea) WHERE d.Id_DBL = ?";

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

    public function EliminarDetalleLineas(int $Id_DBL){

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
}
