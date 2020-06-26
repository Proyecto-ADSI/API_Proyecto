<?php 

declare(strict_types=1);

namespace App\Domain\Visitas;

use JsonSerializable;

class Visitas implements JsonSerializable
{
    private $Id_Visita;

    private $Tipo_Visita;

    private $Id_Asesor;

    private $Id_Cita;

    private $Id_Datos_Visita;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Visita, int $Tipo_Visita,int $Id_Asesor,int $Id_Cita,?int $Id_Datos_Visita)
    {   
        $this->Id_Visita = $Id_Visita;
        $this->Tipo_Visita = $Tipo_Visita;
        $this->Id_Asesor = $Id_Asesor;
        $this->Id_Cita = $Id_Cita;
        $this->Id_Datos_Visita = $Id_Datos_Visita;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Visita" => $this->Id_Visita,
            "Tipo_Visita" => $this->Tipo_Visita,
            "Id_Asesor" => $this->Id_Asesor,
            "Id-Cita" =>$this->Id_Cita,
            "Id_Datos_Visita"=>$this->Id_Datos_Visita
        ];    
    }
}