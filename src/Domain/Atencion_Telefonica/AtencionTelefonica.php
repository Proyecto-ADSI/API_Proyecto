<?php

declare(strict_types=1);

namespace App\Domain\Atencion_Telefonica;

use JsonSerializable;

class AtencionTelefonica implements JsonSerializable
{
    private $Id_AT;

    private $Id_Llamada;

    private $Medio_Envio;

    private $Tiempo_Post_Llamada;

    private $Respuesta_Cliente;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_AT,
        int $Id_Llamada,
        int $Medio_Envio,
        string $Tiempo_Post_Llamada,
        ?string $Respuesta_Cliente
    ) {
        $this->Id_AT = $Id_AT;
        $this->Id_Llamada = $Id_Llamada;
        $this->Medio_Envio = $Medio_Envio;
        $this->Tiempo_Post_Llamada = $Tiempo_Post_Llamada;
        $this->Respuesta_Cliente = $Respuesta_Cliente;
    }

    public function jsonSerialize()
    {
        return [
            "Id_AT" => $this->Id_AT,
            "Id_Llamada" => $this->Id_Llamada,
            "Medio_Envio" => $this->Medio_Envio,
            "Tiempo_Post_Llamada" => $this->Tiempo_Post_Llamada,
            "Respuesta_Cliente" => $this->Respuesta_Cliente,
        ];
    }
}
