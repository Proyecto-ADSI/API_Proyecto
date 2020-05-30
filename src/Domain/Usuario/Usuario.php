<?php 

declare(strict_types=1);

namespace App\Domain\Usuario;

use JsonSerializable;

class Usuario implements JsonSerializable
{
    private $Id_Usuario;
    private $Id_Empleado;
    private $Usuario;
    private $Contrasena;
    private $Id_Rol;
    
    public function __get($attr){
        return $this->$attr;
    }
    
    public function __set($attr,$valor){
         $this->$attr = $valor;
    }


    function __construct(?int $Id_Usuario, int $Id_Empleado, string $Usuario, ?string $Contrasena,int $Id_Rol)
    {
        $this->Id_Usuario = $Id_Usuario;
        $this->Id_Empleado = $Id_Empleado;
        $this->Usuario = $Usuario;
        $this->Contrasena = $Contrasena;
        $this->Id_Rol = $Id_Rol;
    

    }

    public function jsonSerialize()
    {
        return[
            "Id_Usuario" => $this->Id_Usuario,
            "Id_Empleado" => $this->Id_Empleado,
            "Usuario" => $this->Usuario,
            "Contrasena" => $this->Contrasena,
            "Id_Rol" => $this->Id_Rol
        ];    
    }
}