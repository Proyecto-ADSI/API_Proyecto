<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\Cliente\ClienteRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

use function DI\get;

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

    public function ConsultarCliente(int $id)
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
        $sql = "INSERT INTO cliente(NIT_CDV,Razon_Social, Telefono, Direccion, Id_Estado_Cliente, Departamento,Municipio, Barrio_Vereda, Nombre_Lugar, Id_Turno) VALUES (?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(2, $Cliente->__GET("NIT_CDV"));
            $stm->bindValue(3, $Cliente->__GET("Razon_Social"));
            $stm->bindValue(4, $Cliente->__GET("Telefono"));
            $stm->bindValue(5, $Cliente->__GET("Direccion"));
            $stm->bindValue(6, $Cliente->__GET("Id_Estado_Cliente"));
            $stm->bindValue(7, $Cliente->__GET("Departamento"));
            $stm->bindValue(8, $Cliente->__GET("Municipio"));
            $stm->bindValue(9, $Cliente->__GET("Barrio_Vereda"));
            $stm->bindValue(1, $Cliente->__GET("Nombre_Lugar"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function CambiarEstado(int $Id_Cliente,int $Estado)
    {

        $sql ="UPDATE directorio SET Id_Estado_Cliente = ? WHERE Id_Cliente = $Id_Cliente";
            
           
            try{

                if ($Estado == 1) {

                    $stm = $this->db->prepare($sql);
    
                    $stm->bindValue(1 , 2);
    
                    return $stm->execute();
                }
                else if($Estado == 2){
                    
                    $stm = $this->db->prepare($sql);
    
                    $stm->bindValue(1 , 1);
    
                    return $stm->execute();
                }
             

            }
            catch(Exception $e){

                return "Error al cambiar estado "+$e;

            }
        
    }

}
