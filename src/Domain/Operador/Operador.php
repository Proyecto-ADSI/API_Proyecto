<?php

declare(strict_types=1);

namespace App\Domain\Operador;

use JsonSerializable;

class Operador implements JsonSerializable
{
    private $Id_Operador;

    private $Nombre;

    private $Color;

    private $Genera_Oferta;

    private $Correo_Operador;

    private $Contrasena_Operador;

    private $Imagen_Operador;

    private $Estado;

    public function __GET($attr)
    {
        return $this->$attr;
    }

    function __construct(
        ?int $Id_Operador,
        string $Nombre,
        string $Color,
        int $Genera_Oferta,
        ?string $Correo_Operador,
        ?string $Contrasena_Operador,
        string $Imagen_Operador,
        ?int $Estado
    ) {
        $this->Id_Operador = $Id_Operador;
        $this->Nombre = $Nombre;
        $this->Color = $Color;
        $this->Genera_Oferta = $Genera_Oferta;
        $this->Correo_Operador = $Correo_Operador;
        $this->Contrasena_Operador = $Contrasena_Operador;
        $this->Imagen_Operador = $Imagen_Operador;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return [
            "Id_Operador" => $this->Id_Operador,
            "Nombre" => $this->Nombre,
            "Color" => $this->Color,
            "Genera_Oferta" => $this->Genera_Oferta,
            "Correo_Operador" => $this->Correo_Operador,
            "Contrasena_Operador" => $this->Contrasena_Operador,
            "Imagen_Operador" => $this->Imagen_Operador,
            "Estado" => $this->Estado
        ];
    }
}
