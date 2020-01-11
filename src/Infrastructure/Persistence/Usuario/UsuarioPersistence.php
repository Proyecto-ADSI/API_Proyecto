<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Usuario;

use App\Infrastructure\DataBase;
use App\Domain\Usuario\Usuario;
use App\Domain\Usuario\UsuarioRepository;
use Exception;
use PDO;

class UsuarioPersistence implements UsuarioRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }


    public function login(string $usuario)
    {

        $sql = "SELECT Id_Usuario, Usuario, Contrasena, Id_Rol, Id_Empleado FROM usuarios
        WHERE Usuario = ?";

        try {
            
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function RegistrarUsuario(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios(Usuario, Contrasena, Id_Rol,Id_Empleado) VALUE (?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario->__GET("Usuario"));
            $stm->bindValue(2, $usuario->__GET("Contrasena"));
            $stm->bindValue(3, $usuario->__GET("Id_Rol"));
            $stm->bindValue(4, $usuario->__GET("Id_Empleado"));
            
            return $stm->execute();
            
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function AgregarToken(string $token, int $Id_Usuario)
    {
        $sql = "UPDATE usuarios SET Token = ? WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$token);
            $stm->bindValue(2,$Id_Usuario);
            return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ValidarToken(string $token)
    {
        $sql = "SELECT Id_Usuario FROM usuarios WHERE Token = ?";

        try {
            
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1,$token);
            $stm->execute();
            
            return $stm->fetch(PDO::FETCH_ASSOC);
            


        } catch (Exception $e) {
           return $e->getMessage();
        }
    }

    public function EliminarToken(int $Id_Usuario)
    {
        $sql = "UPDATE usuarios SET Token = ? WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            
            $stm->bindValue(1,NULL);
            $stm->bindValue(2,$Id_Usuario);

            return $stm->execute();

        } catch (\Exception $e) {
            return $e;
        }   
    }

    public function RestablecerContrasena(int $Id_Usuario, string $Contrasena)
    {
        $sql = "UPDATE usuarios SET Contrasena = ? WHERE Id_Usuario = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Contrasena);
            $stm->bindValue(2,$Id_Usuario);
            
            return $stm->execute();
            
        } catch (\Exception $e) {
            
        }
    }

    public function ValidarUsuario(string $usuario)
    {
        $sql = "SELECT e.Email FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) WHERE u.Usuario = ? ";

        try {
            
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$usuario);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {

          return $e->getMessage();
        }
    }
}
