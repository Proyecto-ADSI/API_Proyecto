<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Llamada;

use App\Domain\Llamada\Llamada;
use App\Domain\Llamada\LlamadaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class LlamadaPersistence implements LlamadaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }


    public function ListarLlamada()
    {
        $sql = "SELECT Ll.Id_Llamada, d.NIT_CDV, d.Razon_Social, d.Telefono, o.Nombre AS Operador,
        CASE WHEN  ISNULL(dbl.Id_Plan_Corporativo) = 0 THEN 'Si' 
        ELSE 'No' END AS Corporativo 
        FROM Directorio d 
        INNER JOIN Datos_Basicos_Lineas dbl ON(d.Id_Cliente = dbl.Id_Cliente) 
        INNER JOIN Operadores o ON(dbl.Id_Operador = o.Id_Operador)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ObtenerCliente(int $id)
    {
        $sql = "SELECT * FROM Directorio WHERE Id_Cliente = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $id);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }
  


    public function RegistrarLlamada(Llamada $Llamada)
    {
        $sql = "INSERT INTO Llamada(Id_Llamada,Id_DBL, Id_Usuario, Id_Estado_Llamada, Persona_Responde, Fecha_Llamada,
        Info_Habeas_Data,Observacion) 
        VALUES (?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada->__GET("Id_Llamada"));
            $stm->bindValue(2, $Llamada->__GET("Id_DBL"));
            $stm->bindValue(3, $Llamada->__GET("Id_Usuario"));
            $stm->bindValue(4, $Llamada->__GET("Id_Estado_Llamada"));
            $stm->bindValue(5, $Llamada->__GET("Persona_Responde"));
            $stm->bindValue(6,$Llamada->__GET("Fecha_Llamada"));
            $stm->bindValue(5, $Llamada->__GET("Info_Habeas_Data"));
            $stm->bindValue(6,$Llamada->__GET("Observacion"));

            return $stm->execute();
            
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function EditarLlamada(Llamada $Llamada){

        $sql ="UPDATE Llamada SET  Id_DBL = ?, Id_Usuario = ?, Id_Estado_Llamada = ?,
            Persona_Responde = ?, Fecha_Llamada = ?,Info_Habeas_Data = ?, Observacion = ?
            WHERE Id_Llamada = ?";
            
        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Llamada->__GET("Id_DBL"));
            $stm->bindValue(2, $Llamada->__GET("Id_Usuario"));
            $stm->bindValue(3, $Llamada->__GET("Id_Estado_Llamada"));
            $stm->bindValue(4, $Llamada->__GET("Persona_Responde"));
            $stm->bindValue(5, $Llamada->__GET("Fecha_Llamada"));
            $stm->bindValue(7, $Llamada->__GET("Info_Habeas_Data"));
            $stm->bindValue(8, $Llamada->__GET("Observacion"));
            $stm->bindValue(9, $Llamada->__GET("Id_Llamada"));
      
            return $stm->execute();             
        }
        catch(Exception $e){

            return $e->getMessage();

        }
    }


    public function CambiarEstadoLlamada(int $Id_Llamada,int $Estado)
    {
        $sql ="UPDATE directorio SET Estado_Cliente = ? WHERE Id_Cliente = ?";
            try{
                $stm = $this->db->prepare($sql);
                $stm->bindValue(1, $Estado);
                $stm->bindValue(2, $Id_Llamada);

                return $stm->execute();             
            }
            catch(Exception $e){

                return "Error al cambiar estado "+$e;

            }
    }

    
    public function EliminarLlamada(int $Id_Llamada){

        $sql = "DELETE FROM Directorio WHERE Id_Cliente = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Llamada);

            return $stm->execute();

        }catch(Exception $e){

            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado(){

        $sql = "SELECT Id_Cliente FROM Directorio ORDER BY 1 DESC LIMIT 1";

        try{

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
