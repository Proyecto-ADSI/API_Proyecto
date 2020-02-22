<?php 

declare(strict_types=1);

namespace App\Domain\Departamento;

use JsonSerializable;

class Departamento implements JsonSerializable
{
    private $Id_Departamento;
    
    private $Nombre;
    
    private $Id_Pais;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Departamento, string $Nombre, int $Id_Pais ,int $Estado)
    {   
        $this->Id_Departamento = $Id_Departamento;
        $this->Nombre = $Nombre;
        $this->Id_Pais = $Id_Pais;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Departamento" => $this->Id_Departamento,
            "Nombre" => $this->Nombre,
            "Id_Pais" => $this->Id_Pais,
            "Estado" => $this->Estado
        ];    
    }
}