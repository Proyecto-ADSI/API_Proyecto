<?php


declare(strict_types=1);


namespace App\Infrastructure\Persistence\Lineas_Fijas;

use App\Domain\Lineas_Fijas\Lineas_Fijas;
use App\Domain\Lineas_Fijas\Lineas_FijasRepository;
use App\Infrastructure\DataBase;
use PDO;

class Lineas_FijasPersistence implements Lineas_FijasRepository
{
    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarLineas_Fijas(Lineas_Fijas $Lineas_Fijas)
    {

        $sql = "INSERT INTO lineas_fijas(Pagina_Web, Correo_Electronico, IP_Fija, Dominio, Telefonia, Television) VALUES (?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Lineas_Fijas->__GET("Pagina_Web"));
            $stm->bindValue(2, $Lineas_Fijas->__GET("Correo_Electronico"));
            $stm->bindValue(3, $Lineas_Fijas->__GET("IP_Fija"));
            $stm->bindValue(4, $Lineas_Fijas->__GET("Dominio"));
            $stm->bindValue(5, $Lineas_Fijas->__GET("Telefonia"));
            $stm->bindValue(6, $Lineas_Fijas->__GET("Television"));

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

    public function ConsultarUltimaLineas_Fijas()
    {
        $sql = "SELECT MAX(Id_Linea_Fija) AS Id_Linea_Fija FROM lineas_fijas ";

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

    public function RegistrarDetalleLineas_Fijas(int $IdLineas_Fijas, int $IdDBL)
    {

        $sql = "INSERT INTO detalle_lineas(Id_Linea_Fija, Id_DBL) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $IdLineas_Fijas);
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

    public function EditarLineas_Fijas(Lineas_Fijas $Lineas_Fijas)
    {

        $sql = "UPDATE lineas_fijas SET  Pagina_Web = ?, Correo_Electronico = ?, IP_Fija = ?, 
        Dominio = ?, Telefonia = ?, Television = ? WHERE Id_Linea_Fija = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Lineas_Fijas->__GET("Pagina_Web"));
            $stm->bindValue(2, $Lineas_Fijas->__GET("Correo_Electronico"));
            $stm->bindValue(3, $Lineas_Fijas->__GET("IP_Fija"));
            $stm->bindValue(4, $Lineas_Fijas->__GET("Dominio"));
            $stm->bindValue(5, $Lineas_Fijas->__GET("Telefonia"));
            $stm->bindValue(6, $Lineas_Fijas->__GET("Television"));
            $stm->bindValue(7, $Lineas_Fijas->__GET("Id_Linea_Fija"));

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

    public function EliminarLineas_Fijas(int $IdLinea_Fija)
    {

        $sql = "DELETE FROM lineas_fijas WHERE Id_Linea_Fija = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $IdLinea_Fija);
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
