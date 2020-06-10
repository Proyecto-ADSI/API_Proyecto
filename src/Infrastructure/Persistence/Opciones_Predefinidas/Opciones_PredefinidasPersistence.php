<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Opciones_Predefinidas;

use App\Domain\Opciones_Predefinidas\Opciones_Predefinidas;
use App\Domain\Opciones_Predefinidas\Opciones_PredefinidasRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class Opciones_PredefinidasPersistence implements Opciones_PredefinidasRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarOpcionesP(Opciones_Predefinidas $Opciones_Predefinidas)
    {
        $sql = "INSERT INTO opciones_predefinidas (Opcion,Categoria) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Opciones_Predefinidas->__GET("Opcion"));
            $stm->bindValue(2, $Opciones_Predefinidas->__GET("Categoria"));

            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarOpcionesP()
    {
        $sql = "SELECT Id_OP,Opcion,Categoria FROM opciones_predefinidas";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarOpcionesPCategoria(string $Categoria)
    {
        $sql = "SELECT Id_OP,Opcion,Categoria FROM opciones_predefinidas WHERE Categoria = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Categoria);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosOpcionesP(int $Id_Opcion_Predefinida)
    {
        $sql = "SELECT  Id_OP,Opcion,Categoria FROM opciones_predefinidas   
        WHERE Id_OP = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Opcion_Predefinida);

            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarOpcionesP(Opciones_Predefinidas $Opciones_Predefinidas)
    {
        $sql = "UPDATE opciones_predefinidas SET Opcion = ?, Categoria = ?  WHERE Id_OP = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Opciones_Predefinidas->__GET("Opcion"));
            $stm->bindValue(2, $Opciones_Predefinidas->__GET("Categoria"));
            $stm->bindValue(3, $Opciones_Predefinidas->__GET("Id_OP"));

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarOopcionesP(int $Id_Opcion_Predefinida)
    {
        $sql = "DELETE FROM opciones_predefinidas WHERE Id_OP = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Opcion_Predefinida);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
