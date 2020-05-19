<?php 

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doc_Soporte;

use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Infrastructure\DataBase;
use PDO;

class Doc_SoportePersistence implements Doc_SoporteRepository
{
    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarDocSoporte(Doc_Soporte $Doc_Soporte)
    {
        $sql = "INSERT INTO Documentos_Soporte(Camara_Comercio,Cedula_RL,Soporte_Ingresos, Detalles_Plan_Corporativo)
        VALUES(?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Doc_Soporte->__GET("Camara_Comercio"));
            $stm->bindValue(2,$Doc_Soporte->__GET("Cedula_RL"));
            $stm->bindValue(3,$Doc_Soporte->__GET("Soporte_Ingresos"));
            $stm->bindValue(4,$Doc_Soporte->__GET("Detalles_Plan_Corporativo"));

            return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarDocSoporte(int $Id_Documentos)
    {
        $sql = "SELECT Camara_Comercio,Cedula_RL,Soporte_Ingresos,Detalles_Plan_Corporativo, Oferta 
        FROM Documentos_Soporte WHERE Id_Documentos = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Documentos);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarDocSoporte(Doc_Soporte $Doc_Soporte){

        $sql = "UPDATE Documentos_Soporte SET Camara_Comercio = ?,Cedula_RL = ?, 
        Soporte_Ingresos = ?, Detalles_Plan_Corporativo = ? WHERE Id_Documentos = ?";

        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Doc_Soporte->__GET("Camara_Comercio"));
            $stm->bindValue(2,$Doc_Soporte->__GET("Cedula_RL"));
            $stm->bindValue(3,$Doc_Soporte->__GET("Soporte_Ingresos"));
            $stm->bindValue(4,$Doc_Soporte->__GET("Detalles_Plan_Corporativo"));
            $stm->bindValue(5,$Doc_Soporte->__GET("Id_Documentos"));

            return $stm->execute();

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function EliminarDocSoporte(int $Id_Documentos)
    {
        $sql = "DELETE FROM Documentos_Soporte WHERE Id_Documentos = ? ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Documentos);
            return  $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado(){

        $sql = "SELECT Id_Documentos FROM Documentos_Soporte ORDER BY 1 DESC LIMIT 1";

        try{

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

