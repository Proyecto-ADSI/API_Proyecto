<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Documento;

use App\Domain\Documento\Documento;
use App\Domain\Documento\DocumentoRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class DocumentoPersistence implements DocumentoRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarDocumento(Documento $Documento)
    {
        $sql = "INSERT INTO documentos(Nombre,Estado) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Documento->__GET("Nombre"));
            $stm->bindValue(2, $Documento->__GET("Estado"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    public function ListarDocumento()
    {
        $sql = "SELECT Id_Documentos, Nombre FROM documentos";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function CambiarEstado(int $Id_Documentos, int $Estado){
        $sql = "UPDATE documentos SET Estado= ? WHERE Id_Documentos = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Documentos);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      }
  
      public function ObtenerDatos($Id_Documentos) : array{
        $sql = "SELECT * FROM documentos WHERE Id_Documentos = ?";
 
        try {
           $stm = $this->db->prepare($sql);
           $stm->bindParam(1, $Id_Documentos);
           
           $stm->execute();
           return $stm->fetch();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarDocumento(Documento $Documento){
        $sql = "UPDATE documentos SET Nombre = ?  WHERE Id_Documentos = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Documento->__GET("Nombre"));
            $stm->bindValue(2, $Documento->__GET("Id_Documento"));
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
}
