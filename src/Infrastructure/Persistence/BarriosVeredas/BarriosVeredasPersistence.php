<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\BarriosVeredas;

use App\Domain\BarriosVeredas\BarriosVeredas;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class BarriosVeredasPersistence implements BarriosVeredasRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarBarriosVeredas(BarriosVeredas $BarriosVeredas)
    {
        $sql = "INSERT INTO barrios_veredas (Codigo, Nombre_Barrio_Vereda, Id_Municipio, Id_SubTipo_Barrio_Vereda,Estado)
        VALUES (?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $BarriosVeredas->__GET("Codigo"));
            $stm->bindValue(2, $BarriosVeredas->__GET("Nombre"));
            $stm->bindValue(3, $BarriosVeredas->__GET("Id_Municipio"));
            $stm->bindValue(4, $BarriosVeredas->__GET("Id_SubTipo_Barrio_Vereda"));
            $stm->bindValue(5, $BarriosVeredas->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarBarriosVeredas()
    {
        $sql = "SELECT b.Id_Barrios_Veredas, b.Codigo , b.Nombre_Barrio_Vereda, b.Estado,m.Id_Municipio, m.Nombre_Municipio
         AS Municipio, s.Id_SubTipo_Barrio_Vereda, s.SubTipo FROM barrios_veredas b
        INNER JOIN municipios m ON (b.Id_Municipio = m.Id_Municipio)                                         
        INNER JOIN subtipo_barrio_vereda s ON (b.Id_SubTipo_Barrio_Vereda = s.Id_SubTipo_Barrio_Vereda)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Barrios_Veredas, int $Estado)
    {
        $sql = "UPDATE barrios_veredas SET Estado= ? WHERE Id_Barrios_Veredas = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Estado);
            $stm->bindParam(2, $Id_Barrios_Veredas);

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerDatosBarriosVeredas(int $Id_Barrios_Veredas)
    {
        $sql = "SELECT b.Id_Barrios_Veredas, b.Codigo , b.Nombre_Barrio_Vereda, m.Id_Municipio, m.Nombre_Municipio,
        s.Id_SubTipo_Barrio_Vereda, s.SubTipo FROM barrios_veredas b                                           
        INNER JOIN municipios m ON (b.Id_Municipio = m.Id_Municipio)                                         
        INNER JOIN subtipo_barrio_vereda s ON (b.Id_SubTipo_Barrio_Vereda = s.Id_SubTipo_Barrio_Vereda)
        WHERE Id_Barrios_Veredas = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $Id_Barrios_Veredas);

            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarBarriosVeredas(BarriosVeredas $BarriosVeredas)
    {
        $sql = "UPDATE barrios_veredas SET Codigo = ?, Nombre_Barrio_Vereda = ?, 
        Id_Municipio = ?, Id_SubTipo_Barrio_Vereda = ? WHERE Id_Barrios_Veredas = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $BarriosVeredas->__GET("Codigo"));
            $stm->bindValue(2, $BarriosVeredas->__GET("Nombre"));
            $stm->bindValue(3, $BarriosVeredas->__GET("Id_Municipio"));
            $stm->bindValue(4, $BarriosVeredas->__GET("Id_SubTipo_Barrio_Vereda"));
            $stm->bindValue(5, $BarriosVeredas->__GET("Id_Barrios_Veredas"));

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ValidarBarriosVeredas(int $Id_Barrios_Veredas)
    {
        $sql = "SELECT Id_Barrios_Veredas FROM citas WHERE  Id_Barrios_Veredas = ?";


        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Barrios_Veredas);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarBarriosVeredas(int $Id_Barrios_Veredas)
    {
        $sql = "DELETE FROM barrios_veredas WHERE Id_Barrios_Veredas = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Barrios_Veredas);


            return $stm->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function ConsultarBarriosVeredasMunicipio(int $Id_Municipio, int $Id_SubTipo)
    {

        $sql = "SELECT Id_Barrios_Veredas, Nombre_Barrio_Vereda FROM barrios_veredas 
        WHERE Id_Municipio = ? AND Id_SubTipo_Barrio_Vereda  = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Municipio);
            $stm->bindValue(2, $Id_SubTipo);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
