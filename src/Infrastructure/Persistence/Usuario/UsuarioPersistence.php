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
        $sql = "SELECT u.Id_Usuario, u.Usuario, c.Conexion, u.Estado_Usuario, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, 
        d.Id_Documento, d.Nombre  AS 'Tipo_Documento', e.Documento, e.Nombre,e.Apellidos,
        CONCAT(e.Nombre,' ',IFNULL(e.Apellidos,'')) AS Nombre_Completo,
        e.Email AS Correo, s.Nombre AS Sexo, IFNULL(e.Celular,'No registrado') Celular, e.Imagen, t.Nombre AS Turno, e.Email_Valido       
        FROM usuarios u 
        INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
        INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
        LEFT JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
        LEFT JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
        LEFT JOIN turnos t ON (e.Id_Turno = t.Id_Turno)
        INNER JOIN conexiones_usuario c ON (c.Id_Conexion_Usuario = u.Id_Conexion_Usuario)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {
            return "Error al listar usuarios: " . $e;
        }
    }


    public function ObtenerUsuario(int $Id_Usuario)
    {
        $sql = "SELECT u.Id_Usuario, u.Usuario, c.Conexion, u.Estado_Usuario, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, d.Id_Documento,
        d.Nombre AS 'Tipo_Documento', e.Documento, e.Nombre, e.Apellidos, e.Email AS Correo, s.Id_Sexo, s.Nombre AS Sexo,
        Celular, Imagen, t.Id_Turno, t.Nombre AS Turno       
        FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
        INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
        INNER JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
        INNER JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
        INNER JOIN turnos t ON (e.Id_Turno = t.Id_Turno)
        INNER JOIN conexiones_usuario c ON (c.Id_Conexion_Usuario = u.Id_Conexion_Usuario) WHERE u.Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return "Error al obtener usuario: " . $e->getMessage();
        }
    }

    public function login(string $usuario)
    {

        $sql = "SELECT u.Id_Usuario, u.Usuario, u.Contrasena, r.Id_Rol, r.Nombre Rol, e.Id_Empleado, CONCAT(e.Nombre,' ',e.Apellidos) Nombre,  e.Email, e.Imagen FROM usuarios u 
        JOIN roles r ON(u.Id_Rol = r.Id_Rol)
        JOIN empleados e ON(u.Id_Empleado = e.Id_Empleado) 
        WHERE u.Usuario = ? AND u.Estado_Usuario = ?";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario);
            $stm->bindValue(2, 1);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
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
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function AgregarToken(string $token, int $Id_Usuario)
    {
        $sql = "UPDATE usuarios SET Token = ? WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $token);
            $stm->bindValue(2, $Id_Usuario);
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
            $stm->bindParam(1, $token);
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

            $stm->bindValue(1, NULL);
            $stm->bindValue(2, $Id_Usuario);

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
            $stm->bindValue(1, $Contrasena);
            $stm->bindValue(2, $Id_Usuario);

            return $stm->execute();
        } catch (\Exception $e) {
        }
    }

    public function ValidarUsuario(string $usuario)
    {
        $sql = "SELECT e.Email FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) WHERE u.Usuario = ? ";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario);
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
            $stm->bindValue(1, $usuario->__GET("Usuario"));
            $stm->bindValue(2, $usuario->__GET("Id_Rol"));
            $stm->bindValue(3, $usuario->__GET("Id_Usuario"));

            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function EditarUsuarioAE(Usuario $usuario)
    {
        $sql = "UPDATE usuarios SET Usuario = ? WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario->__GET("Usuario"));
            $stm->bindValue(2, $usuario->__GET("Id_Usuario"));

            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function CambiarContrasena(int $Id_Usuario, string $Contrasena)
    {
        $sql = "UPDATE usuarios SET Contrasena = ? WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Contrasena);
            $stm->bindValue(2, $Id_Usuario);
            return $stm->execute();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function CambiarEstadoUsuario(int $Id_Usuario, int $Estado)
    {

        $sql = "UPDATE usuarios SET Estado_Usuario = ? WHERE Id_Usuario= ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Estado);
            $stm->bindValue(2, $Id_Usuario);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return true;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (Exception $e) {

            return "Error al cambiar estado " + $e->getMessage();
        }
    }

    public function EliminarUsuario(int $Id_Usuario)
    {
        $sql = "DELETE FROM usuarios WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);

            return $stm->execute();
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ValidarEliminarUsuario(int $Id_Usuario)
    {

        $sql = "SELECT Id_Llamada FROM llamadas WHERE Id_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public  function ObtenerUsuarioRol(int $Id_Rol)
    {
        $sql = null;
        if ($Id_Rol == 1) {
            $sql = "SELECT u.Id_Usuario, u.Usuario, c.Conexion, u.Estado_Usuario, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, 
            d.Nombre AS 'Tipo Documento', e.Documento, e.Nombre, e.Apellidos, e.Email AS Correo, s.Nombre AS Sexo, Celular, Imagen, t.Nombre AS Turno       
            FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
            INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
            LEFT JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
            LEFT JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
            LEFT JOIN turnos t ON (e.Id_Turno = t.Id_Turno)
            INNER JOIN conexiones_usuario c ON (c.Id_Conexion_Usuario = u.Id_Conexion_Usuario)";
        } else if ($Id_Rol == 2) {

            $sql = "SELECT u.Id_Usuario, u.Usuario, c.Conexion, u.Estado_Usuario, u.Id_Rol, r.Nombre AS Rol, u.Id_Empleado, 
            d.Nombre AS 'Tipo Documento', e.Documento, e.Nombre, e.Apellidos, e.Email AS Correo, s.Nombre AS Sexo, Celular, Imagen, t.Nombre AS Turno       
            FROM usuarios u INNER JOIN empleados e ON (u.Id_Empleado = e.Id_Empleado) 
            INNER JOIN roles r ON (u.Id_Rol = r.Id_rol) 
            LEFT JOIN documentos d ON (e.Tipo_Documento = d.Id_Documento) 
            LEFT JOIN sexos s ON (e.Id_Sexo = s.Id_Sexo)
            LEFT JOIN turnos t ON (e.Id_Turno = t.Id_Turno)
            INNER JOIN conexiones_usuario c ON (c.Id_Conexion_Usuario = u.Id_Conexion_Usuario)
            WHERE u.Id_Rol NOT IN ('1','2')";
        }

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
        } catch (\Exception $e) {
            return "Error al listar usuarios: " . $e;
        }
    }

    public function ConsultarUltimoRegistrado()
    {

        $sql = "SELECT Id_Usuario FROM usuarios ORDER BY 1 DESC LIMIT 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
