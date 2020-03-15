<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Plan_Corporativo;

use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Infrastructure\DataBase;
use PDO;

class Plan_CorporativoPersistence implements Plan_CorporativoRepository
{
    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarPlan_Corporativo(Plan_Corporativo $Plan_Corporativo)
    {   

        $sql = "INSERT INTO Plan_Corporativo(Id_Documentos,Fecha_Inicio,Fecha_Fin, Descripcion, Estado_Plan_Corporativo)
        VALUES(?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Plan_Corporativo->__GET("Id_Documentos"));
            $stm->bindValue(2, $Plan_Corporativo->__GET("Fecha_Inicio"));
            $stm->bindValue(3, $Plan_Corporativo->__GET("Fecha_Fin"));
            $stm->bindValue(4, $Plan_Corporativo->__GET("Descripcion"));
            $stm->bindValue(5, $Plan_Corporativo->__GET("Estado_Plan_Corporativo"));

            return $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarPlan_Corporativo(int $Id_Plan_Corporativo)
    {
        $sql = "SELECT IFNULL(Id_Documentos,0) Id_Documentos,Fecha_Inicio,Fecha_Fin,Descripcion,Estado_Plan_Corporativo
                FROM Plan_Corporativo WHERE Id_Plan_Corporativo = ? ";
        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Plan_Corporativo);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarPlan_Corporativo(Plan_Corporativo $Plan_Corporativo){

        $sql = "UPDATE Plan_Corporativo SET Id_Documentos = ?, Fecha_Inicio = ?, 
        Fecha_Fin = ?, Descripcion = ? WHERE Id_Plan_Corporativo = ?";

        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Plan_Corporativo->__GET("Id_Documentos"));
            $stm->bindValue(2,$Plan_Corporativo->__GET("Fecha_Inicio"));
            $stm->bindValue(3,$Plan_Corporativo->__GET("Fecha_Fin"));
            $stm->bindValue(4,$Plan_Corporativo->__GET("Descripcion"));
            $stm->bindValue(5,$Plan_Corporativo->__GET("Id_Plan_Corporativo"));
     

            return $stm->execute();

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Plan_Corporativo, int $Estado)
    {
        $sql = "UPDATE Plan_Corporativo SET Estado = ? WHERE Id_Plan_Corporativo = ? ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Estado);
            $stm->bindValue(2, $Id_Plan_Corporativo);

            return  $stm->execute();

        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    public function EliminarPlan_Corporativo(int $Id_Plan_Corporativo)
    {
        $sql = "DELETE FROM Plan_Corporativo WHERE Id_Plan_Corporativo = ? ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Plan_Corporativo);
            return  $stm->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado(){

        $sql = "SELECT Id_Plan_Corporativo FROM Plan_Corporativo ORDER BY 1 DESC LIMIT 1";

        try{

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
