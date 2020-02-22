<?php 

declare(strict_types=1);

namespace App\Domain\Municipio;

use JsonSerializable;

class Municipio implements JsonSerializable
{
    private $Id_Municipios;
    
    private $Nombre;
    
    private $Id_Departamento;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Municipios, string $Nombre, int $Id_Departamento ,int $Estado)
    {   
        $this->Id_Municipios = $Id_Municipios;
        $this->Nombre = $Nombre;
        $this->Id_Departamento = $Id_Departamento;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Municipios" => $this->Id_Municipios,
            "Nombre" => $this->Nombre,
            "Id_Departamentos" => $this->Id_Departamento,
            "Estado" => $this->Estado
        ];    
    }
}