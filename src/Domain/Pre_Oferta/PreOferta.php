<?php

declare(strict_types=1);

namespace App\Domain\Pre_Oferta;

use JsonSerializable;

class PreOferta implements JsonSerializable
{
    private $Id_Pre_Oferta;

    private $Id_AT;

    private $Id_Visita;

    private $Id_Usuario;

    private $Id_Estado_PO;

    private $Nombre_Cliente;

    private $Mensaje_Superior;

    private $Tipo_Pre_Oferta;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Pre_Oferta,
        ?int $Id_AT,
        ?int $Id_Visita,
        ?int $Id_Usuario,
        int $Id_Estado_PO,
        ?string $Nombre_Cliente,
        ?string $Mensaje_Superior,
        int $Tipo_Pre_Oferta
    ) {
        $this->Id_Pre_Oferta = $Id_Pre_Oferta;
        $this->Id_AT = $Id_AT;
        $this->Id_Visita = $Id_Visita;
        $this->Id_Usuario = $Id_Usuario;
        $this->Id_Estado_PO = $Id_Estado_PO;
        $this->Nombre_Cliente = $Nombre_Cliente;
        $this->Mensaje_Superior = $Mensaje_Superior;
        $this->Tipo_Pre_Oferta = $Tipo_Pre_Oferta;
    }

    public function jsonSerialize()
    {
        return [
            "Id_Pre_Oferta" => $this->Id_Pre_Oferta,
            "Id_AT" => $this->Id_AT,
            "Id_Visita" => $this->Id_Visita,
            "Id_Usuario" => $this->Id_Usuario,
            "Id_Estado_PO" => $this->Id_Estado_PO,
            "Nombre_Cliente" => $this->Nombre_Cliente,
            "Mensaje_Superior" => $this->Mensaje_Superior,
            "Tipo_Pre_Oferta" => $this->Tipo_Pre_Oferta,
        ];
    }
}
