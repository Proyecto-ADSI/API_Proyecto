<?php 

declare(strict_types=1);

namespace App\Domain\Llamada;

use JsonSerializable;

class Llamada implements JsonSerializable
{
    private $Id_Llamada;
    private $Id_Cliente;
    private $Id_Usuario;
    private $Id_Estado_Llamada;
    private $Persona_Responde;
    private $Fecha_Llamada;
    private $Info_Habeas_Data;
    private $Observacion;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(
        ?int $Id_Llamada, int $Id_Cliente, int $Id_Usuario,string $Id_Estado_Llamada, 
        string $Persona_Responde,string $Fecha_Llamada,string $Info_Habeas_Data,string $Observacion
    )
    {   
        $this->Id_Llamada = $Id_Llamada;
        $this->Id_Cliente = $Id_Cliente;
        $this->Id_Usuario = $Id_Usuario;
        $this->Id_Estado_Llamada = $Id_Estado_Llamada;
        $this->Persona_Responde = $Persona_Responde;
        $this->Fecha_Llamada = $Fecha_Llamada;
        $this->Info_Habeas_Data = $Info_Habeas_Data;
        $this->Observacion = $Observacion;

    }

    public function jsonSerialize()
    {
        return[
            "Id_Llamada" => $this->Id_Llamada,
            "Id_Cliente" => $this->Id_Cliente,
            "Id_Usuario" => $this->Id_Usuario,
            "Id_Estado_Llamada" => $this->Id_Estado_Llamada,
            "Persona_Responde" => $this->Persona_Responde,
            "Fecha_Llamada" => $this->Fecha_Llamada,
            "Info_Habeas_Data" => $this->Info_Habeas_Data,
            "Observacion" => $this->Observacion
        ];    
    }
}