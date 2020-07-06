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

    public function RegistrarLinea(Linea $linea)
    {

        $sql = "INSERT INTO lineas_moviles(Linea, Minutos, Navegacion, Mensajes, 
        Minutos_LDI, Cantidad_LDI, Servicios_Ilimitados, Servicios_Adicionales, Cargo_Basico,Grupo)
        VALUES (?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $linea->__GET("Linea"));
            $stm->bindValue(2, $linea->__GET("Minutos"));
            $stm->bindValue(3, $linea->__GET("Navegacion"));
            $stm->bindValue(4, $linea->__GET("Mensajes"));
            $stm->bindValue(5, $linea->__GET("Minutos_LDI"));
            $stm->bindValue(6, $linea->__GET("Cantidad_LDI"));
            $stm->bindValue(7, $linea->__GET("Servicios_Ilimitados"));
            $stm->bindValue(8, $linea->__GET("Servicios_Adicionales"));
            $stm->bindValue(9, $linea->__GET("Cargo_Basico"));
            $stm->bindValue(10, $linea->__GET("Grupo"));

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
        $sql = "SELECT MAX(Id_Linea_Movil) AS Id_Linea_Movil FROM lineas_moviles ";

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

    public function RegistrarDetalleLinea(int $IdLinea, int $IdDBL)
    {

        $sql = "INSERT INTO detalle_lineas(Id_Linea_Movil, Id_DBL) VALUES (?,?)";

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

    public function EditarLinea(Linea $linea)
    {

        $sql = "UPDATE lineas_moviles SET  Linea = ?, Minutos = ?, Navegacion = ?, 
        Mensajes = ?, Servicios_Ilimitados = ?, Minutos_LDI = ?, Cantidad_LDI = ?, Servicios_Adicionales = ?, 
        Cargo_Basico = ?, Grupo = ? WHERE Id_Linea_Movil = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $linea->__GET("Linea"));
            $stm->bindValue(2, $linea->__GET("Minutos"));
            $stm->bindValue(3, $linea->__GET("Navegacion"));
            $stm->bindValue(4, $linea->__GET("Mensajes"));
            $stm->bindValue(5, $linea->__GET("Servicios_Ilimitados"));
            $stm->bindValue(6, $linea->__GET("Minutos_LDI"));
            $stm->bindValue(7, $linea->__GET("Cantidad_LDI"));
            $stm->bindValue(8, $linea->__GET("Servicios_Adicionales"));
            $stm->bindValue(9, $linea->__GET("Cargo_Basico"));
            $stm->bindValue(10, $linea->__GET("Grupo"));
            $stm->bindValue(11, $linea->__GET("Id_Linea_Movil"));

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

    public function EliminarLinea(int $IdLinea)
    {

        $sql = "DELETE FROM lineas_moviles WHERE Id_Linea_Movil = ?";

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
