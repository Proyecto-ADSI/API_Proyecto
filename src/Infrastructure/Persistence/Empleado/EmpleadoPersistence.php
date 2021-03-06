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


    public function ListarEmpleados()
    {
        $sql = "SELECT e.Id_Empleado, CONCAT(e.Nombre,' ', e.Apellidos) AS Nombre, e.Documento, r.Nombre AS Rol  FROM empleados e INNER JOIN usuarios u 
                ON (e.Id_Empleado = u.Id_Empleado) INNER JOIN roles r ON (u.Id_Rol = r.Id_rol)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function FiltrarEmpleados(string $texto)
    {
        $sql = "SELECT e.Id_Empleado, CONCAT(e.Nombre,' ', e.Apellidos) AS Nombre, e.Documento, r.Nombre AS Rol  FROM empleados e INNER JOIN usuarios u 
        ON (e.Id_Empleado = u.Id_Empleado) INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
        WHERE e.Nombre LIKE '%" . $texto . "%' OR e.Apellidos LIKE '%" . $texto . "%' OR e.Documento LIKE '%" . $texto . "%'";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarEmpleado(int $id)
    {
        $sql = "SELECT * FROM empleados WHERE Id_Empleado = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $id);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }


    public function RegistrarEmpleado(Empleado $empleado)
    {
        $sql = "INSERT INTO empleados(Tipo_Documento,Documento, Nombre, Apellidos, Email, Id_Sexo, Celular, Imagen, Id_Turno,Email_Valido) VALUES (?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $empleado->__GET("Tipo_Documento"));
            $stm->bindValue(2, $empleado->__GET("Documento"));
            $stm->bindValue(3, $empleado->__GET("Nombre"));
            $stm->bindValue(4, $empleado->__GET("Apellidos"));
            $stm->bindValue(5, $empleado->__GET("Email"));
            $stm->bindValue(6, $empleado->__GET("Sexo"));
            $stm->bindValue(7, $empleado->__GET("Celular"));
            $stm->bindValue(8, $empleado->__GET("Imagen"));
            $stm->bindValue(9, $empleado->__GET("Turno"));
            $stm->bindValue(10, $empleado->__GET("Email_Valido"));

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ConsultarUltimoEmpleado()
    {
        $sql = "SELECT MAX(Id_Empleado) AS Id_Empleado FROM empleados ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return  $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ListarRoles()
    {
        $sql = "SELECT Nombre FROM Roles";

        try {

            $stm = $this->db->prepare($sql);

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EditarEmpleado(Empleado $empleado)
    {
        $sql = "UPDATE empleados SET Tipo_Documento = ?, Documento = ?, Nombre = ?, Apellidos = ?, 
        Email = ?, Id_Sexo = ?, Celular = ?, Imagen = ?, Id_Turno = ?
        WHERE Id_Empleado = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $empleado->__GET("Tipo_Documento"));
            $stm->bindValue(2, $empleado->__GET("Documento"));
            $stm->bindValue(3, $empleado->__GET("Nombre"));
            $stm->bindValue(4, $empleado->__GET("Apellidos"));
            $stm->bindValue(5, $empleado->__GET("Email"));
            $stm->bindValue(6, $empleado->__GET("Sexo"));
            $stm->bindValue(7, $empleado->__GET("Celular"));
            $stm->bindValue(8, $empleado->__GET("Imagen"));
            $stm->bindValue(9, $empleado->__GET("Turno"));
            $stm->bindValue(10, $empleado->__GET("Id_Empleado"));

            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function EditarEmpleadoAE(Empleado $empleado)
    {
        $sql = "UPDATE empleados SET Nombre = ?, Email = ?, Imagen = ? WHERE Id_Empleado = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $empleado->__GET("Nombre"));
            $stm->bindValue(2, $empleado->__GET("Email"));
            $stm->bindValue(3, $empleado->__GET("Imagen"));
            $stm->bindValue(4, $empleado->__GET("Id_Empleado"));
            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function ValidarEmpleado(string $documento)
    {
        $sql = "SELECT Id_Empleado FROM empleados WHERE Documento = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $documento);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function ValidarCorreo(int $Empleado)
    {
        $sql = "UPDATE empleados SET Email_Valido = ?  WHERE Id_Empleado = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, 1);
            $stm->bindValue(2, $Empleado);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
