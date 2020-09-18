<?php 

declare(strict_types=1);

namespace App\Domain\Datos_Visita;

use JsonSerializable;

class Datos_Visita implements JsonSerializable
{
    private $Id_Datos_Visita;

    private $Tipo_Venta;

    private $Calificacion;

    private $Sugerencias;

    private $Observacion;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Datos_Visita, string $Tipo_Venta,string $Calificacion,string $Sugerencias, string $Observacion)
    {   
        $this->Id_Datos_Visita = $Id_Datos_Visita;
        $this->Tipo_Venta = $Tipo_Venta;
        $this->Calificacion = $Calificacion;
        $this->Sugerencias = $Sugerencias;
        $this->Observacion = $Observacion;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Datos_Visita" => $this->Id_Datos_Visita,
            "Tipo_Venta" => $this->Tipo_Venta,
            "Calificacion" => $this->Calificacion,
            "Sugerencias" =>$this->Sugerencias,
            "Observacion"=>$this->Observacion
        ];    
    }
}