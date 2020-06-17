<?php 

declare(strict_types=1);

namespace App\Domain\Novedades;

use JsonSerializable;

class Novedades implements JsonSerializable
{
    private $Id_novedad;
    
    private $Descripcion;

    private $Estado_novedad;

    private $Id_Cita;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_novedad, string $Descripcion, int $Estado_novedad, int $Id_Cita)
    {   
        $this->Id_novedad = $Id_novedad;
        $this->Descripcion = $Descripcion;
        $this->Estado_novedad = $Estado_novedad;
        $this->Id_Cita = $Id_Cita;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Novedad" => $this->Id_novedad,
            "Descripcion" => $this->Descripcion,
            "Estado_Novedad" => $this->Estado_novedad,
            "Id_Cita" => $this->Id_Cita
        ];    
    }
}