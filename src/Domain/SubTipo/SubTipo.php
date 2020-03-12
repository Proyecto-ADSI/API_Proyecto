<?php 

declare(strict_types=1);

namespace App\Domain\SubTipo;

use JsonSerializable;

class SubTipo implements JsonSerializable
{
    private $Id_SubTipo_Barrio_Vereda;
    
    private $SubTipo;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(int $Id_SubTipo_Barrio_Vereda, string $SubTipo, ?int $Estado)
    {   
        $this->Id_SubTipo_Barrio_Vereda = $Id_SubTipo_Barrio_Vereda;
        $this->SubTipo = $SubTipo;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_SubTipo_Barrio_Vereda" => $this->Id_SubTipo_Barrio_Vereda,
            "SubTipo" => $this->SubTipo,
            "Estado" => $this->Estado
        ];    
    }
}