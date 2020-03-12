<?php 

declare(strict_types=1);

namespace App\Domain\BarriosVeredas;

use JsonSerializable;

class BarriosVeredas implements JsonSerializable
{
    private $Id_Barrios_Veredas;
    
    private $Codigo;

    private $Nombre;

    private $Id_SubTipo_Barrio_Vereda;

    private $Id_Municipio;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Barrio_Veredas, string $Codigo, string $Nombre,int $Id_SubTipo_Barrio_Vereda ,int $Id_Municipio,?int $Estado)
    {   
        $this->Id_Barrios_Veredas = $Id_Barrio_Veredas;
        $this->Codigo = $Codigo;
        $this->Nombre = $Nombre;
        $this->Id_SubTipo_Barrio_Vereda = $Id_SubTipo_Barrio_Vereda;
        $this->Id_Municipio = $Id_Municipio;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Barrios_Veredas" =>$this->Id_Barrios_Veredas,
            "Codigo" =>$this->Codigo,
            "Nombre" =>$this->Nombre,
            "Id_SubTipo_Barrio_Vereda" => $this->Id_SubTipo_Barrio_Vereda,
            "Id_Municipio" =>$this->Id_Municipio,
            "Estado" => $this->Estado,
        ];    
    }
}