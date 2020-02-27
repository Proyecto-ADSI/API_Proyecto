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

    public function ListarUsuarios()
    {
        $sql = "SELECT u.Id_Usuario, u.Usuario, u.Conexion, u.Estado, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, 
        d.Nombre AS 'Tipo Documento', e.Documento, e.Nombre, e.Apellidos, e.Email AS Correo, s.Nombre AS Sexo, Celular, Imagen, t.Nombre AS Turno       
        FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
        INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
        INNER JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
        INNER JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
        INNER JOIN turnos t ON (e.Id_Turno = t.Id_Turno)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return "Error al listar usuarios: " . $e->getMessage();
        }

    }


    public function ObtenerUsuario(int $Id_Usuario)
    {
        $sql = "SELECT u.Id_Usuario, u.Usuario, u.Conexion, u.Estado, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, d.Id_Documento,
        d.Nombre AS 'Tipo_Documento', e.Documento, e.Nombre, e.Apellidos, e.Email AS Correo, s.Id_Sexo, s.Nombre AS Sexo,
         Celular, Imagen, t.Id_Turno, t.Nombre AS Turno       
        FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
        INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
        INNER JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
        INNER JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
        INNER JOIN turnos t ON (e.Id_Turno = t.Id_Turno) WHERE u.Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1,$Id_Usuario);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return "Error al obtener usuario: " . $e->getMessage();
        }
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

    public function EditarUsuario(Usuario $usuario)
    {
       $sql = "UPDATE usuarios SET Usuario = ?, Id_Rol = ? WHERE Id_Usuario = ?";
       
       try {
           $stm = $this->db->prepare($sql);
           $stm->bindValue(1,$usuario->__GET("Usuario"));
           $stm->bindValue(2,$usuario->__GET("Id_Rol"));
           $stm->bindValue(3,$usuario->__GET("Id_Usuario"));

           return $stm->execute();

       } catch (\Exception $e) {
         
            return $e->getMessage();
       }
    }

}
