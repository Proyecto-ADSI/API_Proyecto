<?php 

declare(strict_types=1);

namespace App\Domain\Documento;

use JsonSerializable;

class Documento implements JsonSerializable
{
    private $Id_Documento;
    
    private $Nombre;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Documento, string $Nombre, ?int $Estado)
    {   
        $this->Id_Documento = $Id_Documento;
        $this->Nombre = $Nombre;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Documento" => $this->Id_Documento,
            "Nombre" => $this->Nombre,
            "Estado" => $this->Estado
        ];    
    }
}