<?php 

declare(strict_types=1);

namespace App\Domain\Municipio;

use JsonSerializable;

class Municipio implements JsonSerializable
{
    private $Id_Municipio;
    
    private $Nombre;
    
    private $Id_Departamento;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Municipio, string $Nombre, int $Id_Departamento ,?int $Estado)
    {   
        $this->Id_Municipio = $Id_Municipio;
        $this->Nombre = $Nombre;
        $this->Id_Departamento = $Id_Departamento;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Municipios" => $this->Id_Municipio,
            "Nombre" => $this->Nombre,
            "Id_Departamentos" => $this->Id_Departamento,
            "Estado" => $this->Estado
        ];    
    }
}