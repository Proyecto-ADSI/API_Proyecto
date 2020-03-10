<?php


declare(strict_types = 1);


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
        $this->db =$database->getConection();
    }



    public function RegistrarDBL(DBL $DBL){

        $sql = "INSERT INTO Datos_Basicos_Lineas(
        Id_Operador,Id_Plan_Corporativo, Cantidad_Lineas, Valor_Mensual,
        Cantidad_Minutos, Cantidad_Navegacion, Llamadas_Internacionales,
        Mensajes_Texto,Aplicaciones,Roaming_Internacional, Estado_DBL) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

        try {
            
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$DBL->__GET("Id_Operador"));
            $stm->bindValue(2,$DBL->__GET("Id_Plan_Corporativo"));
            $stm->bindValue(3,$DBL->__GET("Cantidad_Lineas"));
            $stm->bindValue(4,$DBL->__GET("Valor_Mensual"));
            $stm->bindValue(5,$DBL->__GET("Cantidad_Minutos"));
            $stm->bindValue(6,$DBL->__GET("Cantidad_Navegacion"));
            $stm->bindValue(7,$DBL->__GET("Llamadas_Internacionales"));
            $stm->bindValue(8,$DBL->__GET("Mensajes_Texto"));
            $stm->bindValue(9,$DBL->__GET("Aplicaciones"));
            $stm->bindValue(10,$DBL->__GET("Roaming_Internacional"));
            $stm->bindValue(11,$DBL->__GET("Estado_DBL"));

            return $stm->execute();

        } catch (\Exception $e) {
             
            return $e->getMessage();
        }
    }

    public function ListarDBL(int $Id_DBL){

        $sql = "SELECT Id_DBL,Id_Operador, IFNULL(Id_Plan_Corporativo, 0) Id_Plan_Corporativo, Cantidad_Lineas, Valor_Mensual,
        Cantidad_Minutos, Cantidad_Navegacion, Llamadas_Internacionales, Mensajes_Texto,Aplicaciones,Roaming_Internacional, Estado_DBL
        FROM Datos_Basicos_Lineas WHERE Id_DBL = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_DBL);

            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarDBL(DBL $DBL){

        $sql = "UPDATE Datos_Basicos_lineas SET Id_Cliente = ?,Id_Operador = ?, Id_Plan_Corporativo = ?, Encargado = ?,
        Extension = ?,Telefono = ?, Cantidad_Lineas = ?, Valor_Mensual = ?, Cantidad_Minutos = ?, Cantidad_Navegacion = ?,
        Llamadas_Internacionales = ?, Mensajes_Texto = ?,Aplicaciones = ?,Roaming_Internacional = ?, Estado_DBL = ? 
        WHERE Id_DBL = ?";

        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$DBL->__GET("Id_Cliente"));
            $stm->bindValue(2,$DBL->__GET("Id_Operador"));
            $stm->bindValue(3,$DBL->__GET("Id_Plan_Corporativo"));
            $stm->bindValue(4,$DBL->__GET("Encargado"));
            $stm->bindValue(5,$DBL->__GET("Extension"));
            $stm->bindValue(6,$DBL->__GET("Telefono"));
            $stm->bindValue(7,$DBL->__GET("Cantidad_Lineas"));
            $stm->bindValue(8,$DBL->__GET("Valor_Mensual"));
            $stm->bindValue(9,$DBL->__GET("Cantidad_Minutos"));
            $stm->bindValue(10,$DBL->__GET("Cantidad_Navegacion"));
            $stm->bindValue(11,$DBL->__GET("Llamadas_Internacionales"));
            $stm->bindValue(12,$DBL->__GET("Mensajes_Texto"));
            $stm->bindValue(13,$DBL->__GET("Aplicaciones"));
            $stm->bindValue(14,$DBL->__GET("Roaming_Internacional"));
            $stm->bindValue(15,$DBL->__GET("Estado_DBL"));
            $stm->bindValue(16,$DBL->__GET("Id_DBL"));

            return $stm->execute();

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

    public function CambiarEstadoDBL(int $Id_DBL, int $Estado){

        $sql = "UPDATE Datos_Basicos_Lineas SET Estado_DBL = ? WHERE Id_DBL = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Estado);
            $stm->bindValue(2,$Id_DBL);

            return $stm->execute();

        } catch (\Exception $e) {

         return $e->getMessage();

        }
    }

    public function ELiminarDBL(int $Id_DBL){

        $sql = "DELETE FROM Datos_Basicos_Lineas WHERE Id_DBL = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_DBL);

            return $stm->execute();

        } catch (\Exception $e) {

         return $e->getMessage();

        }

    }

    public function ConsultarUltimoRegistrado(){

        $sql = "SELECT Id_DBL FROM Datos_Basicos_Lineas ORDER BY 1 DESC LIMIT 1";

        try{

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}