<?php

declare(strict_types=1);

namespace App\Domain\Llamada_Programada;

use JsonSerializable;

class Llamada_Programada implements JsonSerializable
{
    private $Id_LP;
    private $Id_Llamada;
    private $Id_Cita;
    private $Id_Visita;
    private $Fecha_LP;
    private $Estado_LP;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_LP,
        ?int $Id_Llamada,
        ?int $Id_Cita,
        ?int $Id_Visita,
        string $Fecha_LP,
        ?int $Estado_LP
    ) {
        $this->Id_LP = $Id_LP;
        $this->Id_Llamada = $Id_Llamada;
        $this->Id_Cita = $Id_Cita;
        $this->Id_Visita_Interna = $Id_Visita;
        $this->Fecha_LP = $Fecha_LP;
        $this->Estado_LP = $Estado_LP;
    }

    public function jsonSerialize()
    {
        return [
            "Id_LP" => $this->Id_LP,
            "Id_Llamada" => $this->Id_Llamada,
            "Id_Cita" => $this->Id_Cita,
            "Id_Visita" => $this->Id_Visita,
            "Fecha_LP" => $this->Fecha_LP,
            "Estado_LP" => $this->Estado_LP
        ];
    }
}
