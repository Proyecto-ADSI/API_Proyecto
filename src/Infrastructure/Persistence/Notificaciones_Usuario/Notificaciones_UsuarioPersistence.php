<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Notificaciones_Usuario;

use App\Domain\Notificaciones_Usuario\Notificaciones_Usuario;
use App\Domain\Notificaciones_Usuario\Notificaciones_UsuarioRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class Notificaciones_UsuarioPersistence implements Notificaciones_UsuarioRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarNotificacion_Usuario(Notificaciones_Usuario $Notificaciones_Usuario){
        $sql = "INSERT INTO notificaciones_usuarios (Id_Usuario, Id_Notificacion) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Notificaciones_Usuario->__GET("Id_Usuario"));
            $stm->bindValue(2, $Notificaciones_Usuario->__GET("Id_Notificacion"));
            $res = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return  $res;
            } else {
                return $stm->errorInfo();
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarNotificaciones_Usuario(int $Id_Usuario){
        $sql = "SELECT nu.Id_NU, n.Id_Notificacion, DATE_FORMAT(n.Fecha_Notificacion,'%e/%b/%Y %h:%i %p') as Fecha_Notificacion,
        n.Mensaje, cn.Id_Categoria_N, cn.Categoria, u.Id_Usuario, 
        u.Usuario, e.Imagen, r.Nombre as Nombre_Rol    
        FROM notificaciones_usuarios nu
        JOIN notificaciones n ON(nu.Id_Notificacion = n.Id_Notificacion)
        JOIN categorias_notificacion cn ON(n.Id_Categoria_N = cn.Id_Categoria_N)
        JOIN usuarios u ON(n.Id_Usuario = u.Id_Usuario) 
        JOIN empleados e ON(u.Id_Empleado = e.Id_Empleado)
        JOIN roles r ON(u.Id_Rol = r.Id_Rol)
        WHERE nu.Id_Usuario = ? ORDER BY n.Fecha_Notificacion desc";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);  
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return "Error al listar" . $e->getMessage();
        }
    }

    public function ListarNotificacionesNoLeidas(int $Id_Usuario){
        $sql = "SELECT nu.Id_NU, DATE_FORMAT(n.Fecha_Notificacion,'%e/%b/%Y %h:%i %p') as Fecha_Notificacion,
        n.Mensaje, n.Id_Categoria_N, u.Usuario  
        FROM notificaciones_usuarios nu
        JOIN notificaciones n ON(nu.Id_Notificacion = n.Id_Notificacion)
        JOIN usuarios u ON(n.Id_Usuario = u.Id_Usuario) 
        WHERE nu.Id_Usuario = ? AND nu.Estado_Notificacion = ? ORDER BY n.Fecha_Notificacion desc";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, 0);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);  
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return "Error al listar" . $e->getMessage();
        }
    }

    public function CambiarEstadoNU(int $Id_NU, int $EstadoNU){
        $sql = "UPDATE notificaciones_usuarios SET Estado_Notificacion= ? WHERE Id_NU = ?";
   
        try {
          $stm = $this->db->prepare($sql);
          $stm->bindParam(1, $Estado);
          $stm->bindParam(2, $Id_Pais);
   
          return $stm->execute();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarNotificacion_Usuario(int $Id_NU){
        $sql = "DELETE FROM notificaciones_usuarios WHERE Id_NU = ?";
 
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_NU);
            
            return $stm->execute();
 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarIdUsuarios(int $Id_Rol){
        $sql = "SELECT Id_Usuario FROM usuarios WHERE Id_Rol = ? AND Estado_Usuario = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Rol);
            $stm->bindValue(2, 1);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);  
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return "Error al listar" . $e->getMessage();
        }
    }
}
