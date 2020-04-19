<?php


declare(strict_types=1);


namespace App\Infrastructure\Persistence\Linea;

use App\Domain\Linea\Linea;
use App\Domain\Linea\LineaRepository;
use App\Infrastructure\DataBase;
use PDO;

class LineaPersistence implements LineaRepository
{
    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }
    
    public function RegistrarLinea(Linea $linea){

        $sql = "INSERT INTO lineas(Linea, Minutos, Navegacion, Mensajes, Redes_Sociales, 
        Llamadas_Inter, Roaming, Cargo_Basico,Grupo)
        VALUES (?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $linea->__GET("Linea"));
            $stm->bindValue(2, $linea->__GET("Minutos"));
            $stm->bindValue(3, $linea->__GET("Navegacion"));
            $stm->bindValue(4, $linea->__GET("Mensajes"));
            $stm->bindValue(5, $linea->__GET("Redes_Sociales"));
            $stm->bindValue(6, $linea->__GET("Llamadas_Inter"));
            $stm->bindValue(7, $linea->__GET("Roaming"));
            $stm->bindValue(8, $linea->__GET("Cargo_Basico"));
            $stm->bindValue(9, $linea->__GET("Grupo"));

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

    public function ConsultarUltimaLinea()
    {
        $sql = "SELECT MAX(Id_Linea) AS Id_Linea FROM lineas ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {

                return  $stm->fetch(PDO::FETCH_ASSOC);

            } else {
                return $stm->errorInfo();
            }

            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarDetalleLinea(int $IdLinea, int $IdDBL){

        $sql = "INSERT INTO detalle_lineas(Id_Linea, Id_DBL) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $IdLinea);
            $stm->bindValue(2, $IdDBL);
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

    public function EditarLinea(Linea $linea){

        $sql = "UPDATE lineas SET  Linea = ?, Minutos = ?, Navegacion = ?, 
        Mensajes = ?, Redes_Sociales = ?, Llamadas_Inter = ?, Roaming = ?, Cargo_Basico = ?, Grupo = ?
        WHERE Id_Linea = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $linea->__GET("Linea"));
            $stm->bindValue(2, $linea->__GET("Minutos"));
            $stm->bindValue(3, $linea->__GET("Navegacion"));
            $stm->bindValue(4, $linea->__GET("Mensajes"));
            $stm->bindValue(5, $linea->__GET("Redes_Sociales"));
            $stm->bindValue(6, $linea->__GET("Llamadas_Inter"));
            $stm->bindValue(7, $linea->__GET("Roaming"));
            $stm->bindValue(8, $linea->__GET("Cargo_Basico"));
            $stm->bindValue(9, $linea->__GET("Grupo"));
            $stm->bindValue(10, $linea->__GET("Id_Linea"));
            
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

    public function EliminarLinea(int $IdLinea){

        $sql = "DELETE FROM lineas WHERE Id_Linea = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $IdLinea);
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