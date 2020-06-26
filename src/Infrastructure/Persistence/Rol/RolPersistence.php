<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Rol;

use App\Domain\Rol\Rol;
use App\Domain\Rol\RolRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class RolPersistence implements RolRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarRol(Rol $Rol)
    {
        $sql = "INSERT INTO roles(Nombre,Estado) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Rol->__GET("Nombre"));
            $stm->bindValue(2, $Rol->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarRol()
    {
        $sql = "SELECT Id_Rol, Nombre,Estado FROM roles";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Rol, int $Estado)
    {
        $sql = "UPDATE roles SET Estado= ? WHERE Id_Rol = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Estado);
            $stm->bindParam(2, $Id_Rol);

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosRol($Id_Rol)
    {
        $sql = "SELECT * FROM roles WHERE Id_Rol = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Rol);

            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarRol(Rol $Rol)
    {
        $sql = "UPDATE roles SET Nombre = ?  WHERE Id_Rol = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Rol->__GET("Nombre"));
            $stm->bindValue(2, $Rol->__GET("Id_Rol"));

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function RolValUsuario(int $Id_Rol)
    {
        $sql = null;
        if ($Id_Rol == 1) {
            $sql = "SELECT Id_Rol, Nombre FROM roles WHERE Id_Rol NOT IN ('1','5')";
        } else if ($Id_Rol == 2) {
            $sql = "SELECT Id_Rol, Nombre FROM roles WHERE Id_Rol NOT IN ('1','2','5')";
        }
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
