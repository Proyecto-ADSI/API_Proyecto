<?php 

declare(strict_types=1);

namespace App\Domain\Rol;

use JsonSerializable;

class Rol implements JsonSerializable
{
    private $Id_Rol;
    
    private $Nombre;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(int $Id_Rol, string $Nombre, int $Estado)
    {   
        $this->Id_Rol = $Id_Rol;
        $this->Nombre = $Nombre;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Rol" => $this->Id_Rol,
            "Nombre" => $this->Nombre,
            "Estado" => $this->Estado
        ];    
    }
}