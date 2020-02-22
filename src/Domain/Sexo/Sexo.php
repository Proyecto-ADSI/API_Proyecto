<?php 

declare(strict_types=1);

namespace App\Domain\Sexo;

use JsonSerializable;

class Sexo implements JsonSerializable
{
    private $Id_Sexo;
    
    private $Nombre;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Sexo, string $Nombre, int $Estado)
    {   
        $this->Id_Sexo = $Id_Sexo;
        $this->Nombre = $Nombre;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Sexo" => $this->Id_Sexo,
            "Nombre" => $this->Nombre,
            "Estado" => $this->Estado
        ];    
    }
}