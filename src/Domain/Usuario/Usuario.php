<?php 

declare(strict_types=1);

namespace App\Domain\Usuario;

use JsonSerializable;

class Usuario implements JsonSerializable
{
    private $Id_Usuario;
    private $Usuario;
    private $Contrasena;
    private $Id_Rol;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Usuario, string $Usuario, string $Contrasena,int $Id_Rol)
    {
        $this->Id_Usuario = $Id_Usuario;
        $this->Usuario = $Usuario;
        $this->Contrasena = $Contrasena;
        $this->Id_Rol = $Id_Rol;
    

    }

    public function jsonSerialize()
    {
        return[
            "Id_Usuario" => $this->Id_Usuario,
            "Usuario" => $this->Usuario,
            "Contrasena" => $this->Contrasena,
            "Id_Rol" => $this->Id_Rol
        ];    
    }
}