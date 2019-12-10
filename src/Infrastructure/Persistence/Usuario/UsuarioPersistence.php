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

        $sql = "SELECT Id_Usuario, Usuario, Contrasena, Id_Rol FROM usuarios
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

    public function registro(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios(Usuario, Contrasena, Id_Rol) VALUE (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $usuario->__GET("Usuario"));
            $stm->bindValue(2, $usuario->__GET("Contrasena"));
            $stm->bindValue(3, $usuario->__GET("Id_Rol"));

            return $stm->execute();
            
        } catch (Exception $e) {

            return false;
        }
    }

    public function ultimo()
    {
        $sql = "SELECT MAX(Id_Usuario) AS Id_Usuario FROM usuarios ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return  $stm->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            return false;
        }
    }
}
