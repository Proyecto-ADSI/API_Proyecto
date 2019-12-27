<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Empleado;

use App\Domain\Empleado\Empleado;
use App\Domain\Empleado\EmpleadoRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class EmpleadoPersistence implements EmpleadoRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function ConsultarEmpleado(int $id)
    {
        $sql = "SELECT * FROM empleados WHERE Id_Usuario = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindParam(1,$id);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);


        } catch (Exception $e) {

            return $e;
        }
    }


    public function RegistrarEmpleado(Empleado $empleado)
    {
        $sql = "INSERT INTO empleados(Id_Usuario, Documento, Nombre, Apellido, Email, Sexo, Turno) VALUE (?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $empleado->__GET("Id_Usuario"));
            $stm->bindValue(2, $empleado->__GET("Documento"));
            $stm->bindValue(3, $empleado->__GET("Nombre"));
            $stm->bindValue(4, $empleado->__GET("Apellido"));
            $stm->bindValue(5, $empleado->__GET("Email"));
            $stm->bindValue(6, $empleado->__GET("Sexo"));
            $stm->bindValue(7, $empleado->__GET("Turno"));

            return $stm->execute();
            
        } catch (Exception $e) {

            return false;
        }
    }
}
