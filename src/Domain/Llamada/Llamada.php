<?php 

declare(strict_types=1);

namespace App\Domain\Llamada;

use JsonSerializable;

class Llamada implements JsonSerializable
{
    private $Id_Llamada;
    private $Id_Cliente;
    private $Id_Usuario;
    private $Persona_Responde;
    private $Fecha_Llamada;
    private $Duracion_Llamada;
    private $Info_Habeas_Data;
    private $Observacion;
    private $Tipo_Llamada;
    private $Id_Estado_Llamada;
    
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Llamada, int $Id_Usuario, ?int $Id_Cliente,?string $Persona_Responde, 
        ?string $Fecha_Llamada, ?string $Duracion_Llamada, ?int $Info_Habeas_Data, string $Observacion, int $Tipo_Llamada, int $Id_Estado_Llamada 
    )
    {   
        $this->Id_Llamada = $Id_Llamada;
        $this->Id_Cliente = $Id_Cliente;
        $this->Id_Usuario = $Id_Usuario;
        $this->Persona_Responde = $Persona_Responde;
        $this->Fecha_Llamada = $Fecha_Llamada;
        $this->Duracion_Llamada = $Duracion_Llamada;
        $this->Info_Habeas_Data = $Info_Habeas_Data;
        $this->Observacion = $Observacion;
        $this->Tipo_Llamada = $Tipo_Llamada;
        $this->Id_Estado_Llamada = $Id_Estado_Llamada;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Llamada" => $this->Id_Llamada,
            "Id_Cliente" => $this->Id_Cliente,
            "Id_Usuario" => $this->Id_Usuario,
            "Persona_Responde" => $this->Persona_Responde,
            "Fecha_Llamada" => $this->Fecha_Llamada,
            "Duracion_Llamada" => $this->Duracion_Llamada,
            "Info_Habeas_Data" => $this->Info_Habeas_Data,
            "Observacion" => $this->Observacion,
            "Tipo_Llamada" => $this->Tipo_Llamada,
            "Id_Estado_Llamada" => $this->Id_Estado_Llamada
        ];    
    }
}