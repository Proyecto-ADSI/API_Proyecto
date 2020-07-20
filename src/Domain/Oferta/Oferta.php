<?php

declare(strict_types=1);

namespace App\Domain\Oferta;

use JsonSerializable;

class Oferta implements JsonSerializable
{
    private $Id_Oferta;

    private $Id_AT;

    private $Id_Visita;

    private $Id_Usuario;

    private $Nombre_Cliente;

    private $Mensaje_Superior;

    private $Tipo_Oferta;

    private $Respuesta_Cliente;

    private $Fecha_Activacion;

    private $Id_Estado_Oferta;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Oferta,
        ?int $Id_AT,
        ?int $Id_Visita,
        ?int $Id_Usuario,
        ?string $Nombre_Cliente,
        ?string $Mensaje_Superior,
        int $Tipo_Oferta,
        ?string $Respuesta_Cliente,
        ?string $Fecha_Activacion,
        int $Id_Estado_Oferta
    ) {
        $this->Id_Oferta = $Id_Oferta;
        $this->Id_AT = $Id_AT;
        $this->Id_Visita = $Id_Visita;
        $this->Id_Usuario = $Id_Usuario;
        $this->Nombre_Cliente = $Nombre_Cliente;
        $this->Mensaje_Superior = $Mensaje_Superior;
        $this->Tipo_Oferta = $Tipo_Oferta;
        $this->Respuesta_Cliente = $Respuesta_Cliente;
        $this->Fecha_Activacion = $Fecha_Activacion;
        $this->Id_Estado_Oferta = $Id_Estado_Oferta;
    }

    public function jsonSerialize()
    {
        return [
            "Id_Oferta" => $this->Id_Oferta,
            "Id_AT" => $this->Id_AT,
            "Id_Visita" => $this->Id_Visita,
            "Id_Usuario" => $this->Id_Usuario,
            "Nombre_Cliente" => $this->Nombre_Cliente,
            "Mensaje_Superior" => $this->Mensaje_Superior,
            "Tipo_Oferta" => $this->Tipo_Oferta,
            "Respuesta_Cliente" => $this->Respuesta_Cliente,
            "Fecha_Activacion" => $this->Fecha_Activacion,
            "Id_Estado_Oferta" => $this->Id_Estado_Oferta
        ];
    }
}
