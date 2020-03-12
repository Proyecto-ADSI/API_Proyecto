<?php 

declare(strict_types=1);

namespace App\Domain\Operador;

use JsonSerializable;

class Operador implements JsonSerializable
{
    private $Id_Operador;
    
    private $Nombre;
    
    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Operador, string $Nombre ,?int $Estado)
    {   
        $this->Id_Operador = $Id_Operador;
        $this->Nombre = $Nombre;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Operador" => $this->Id_Operador,
            "Nombre" => $this->Nombre,
            "Estado" => $this->Estado
        ];    
    }
}