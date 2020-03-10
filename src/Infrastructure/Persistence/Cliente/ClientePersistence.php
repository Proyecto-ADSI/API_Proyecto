<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\Cliente\ClienteRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class ClientePersistence implements ClienteRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }


    public function ListarCliente()
    {
        $sql = "SELECT * FROM Directorio";

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


    public function RegistrarCliente(Cliente $Cliente)
    {
        $sql = "INSERT INTO Directorio(NIT_CDV,Razon_Social, Telefono, Direccion, Departamento,
        Municipio, Barrio_Vereda, Nombre_Lugar, Estado_Cliente) 
        VALUES (?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(2, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(3, $Cliente->__GET("Telefono"));
            $stm->bindValue(4, $Cliente->__GET("Direccion"));
            $stm->bindValue(5, $Cliente->__GET("Departamento"));
            $stm->bindValue(6, $Cliente->__GET("Municipio"));
            $stm->bindValue(7, $Cliente->__GET("Barrio_Vereda"));
            $stm->bindValue(8, $Cliente->__GET("Nombre_Lugar"));
            $stm->bindValue(9,$Cliente->__GET("Estado_Cliente"));

            return $stm->execute();
            
        } catch (Exception $e) {

            return "Error al registrar " . $e->getMessage();
        }
    }

    public function EditarCliente(Cliente $Cliente){

        $sql ="UPDATE Directorio SET NIT_CDV = ?, Razon_Social = ?, Telefono = ?, Direccion = ?,
            Departamento = ?, Municipio = ?, Barrio_Vereda = ?, Nombre_Lugar = ?, Estado_Cliente = ?
            WHERE Id_Cliente = ?";
            
        try{

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(2, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(3, $Cliente->__GET("Telefono"));
            $stm->bindValue(4, $Cliente->__GET("Direccion"));
            $stm->bindValue(5, $Cliente->__GET("Departamento"));
            $stm->bindValue(6, $Cliente->__GET("Barrio_Vereda"));
            $stm->bindValue(7, $Cliente->__GET("Nombre_Lugar"));
            $stm->bindValue(8, $Cliente->__GET("Estado_Cliente"));
            $stm->bindValue(9, $Cliente->__GET("Id_Cliente"));
      
            return $stm->execute();             
        }
        catch(Exception $e){

            return $e->getMessage();

        }
    }


    public function CambiarEstadoCliente(int $Id_Cliente,int $Estado)
    {
        $sql ="UPDATE directorio SET Estado_Cliente = ? WHERE Id_Cliente = ?";
            try{
                $stm = $this->db->prepare($sql);
                $stm->bindValue(1, $Estado);
                $stm->bindValue(2, $Id_Cliente);

                return $stm->execute();             
            }
            catch(Exception $e){

                return "Error al cambiar estado "+$e;

            }
    }

    
    public function EliminarCliente(int $Id_Cliente){

        $sql = "DELETE FROM Directorio WHERE Id_Cliente = ?";

        try{
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Cliente);

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