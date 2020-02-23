<?php 

declare(strict_types=1);

namespace App\Domain\Pais;

use JsonSerializable;

class Pais implements JsonSerializable
{
    private $Id_Pais;
    
    private $Nombre;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Pais, string $Nombre, int $Estado)
    {   
        $this->Id_Pais = $Id_Pais;
        $this->Nombre = $Nombre;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Pais" => $this->Id_Pais,
            "Nombre" => $this->Nombre,
            "Estado" => $this->Estado
        ];    
    }
}