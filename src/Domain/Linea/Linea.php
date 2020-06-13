<?php

declare(strict_types=1);

namespace App\Domain\Linea;

use JsonSerializable;

class Linea implements JsonSerializable
{

    private $Id_Linea_Movil;
    private $Linea;
    private $Minutos;
    private $Navegacion;
    private $Mensajes;
    private $Redes_Sociales;
    private $Minutos_LDI;
    private $Cantidad_LDI;
    private $Servicios_Adicionales;
    private $Cargo_Basico;
    private $Grupo;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Linea_Movil,
        ?string $Linea,
        ?string $Minutos,
        ?string $Navegacion,
        ?string $Mensajes,
        ?string $Redes_Sociales,
        ?string $Minutos_LDI,
        ?string $Cantidad_LDI,
        ?string $Servicios_Adicionales,
        ?string $Cargo_Basico,
        ?int $Grupo

    ) {
        $this->Id_Linea_Movil = $Id_Linea_Movil;
        $this->Linea = $Linea;
        $this->Minutos = $Minutos;
        $this->Navegacion = $Navegacion;
        $this->Mensajes = $Mensajes;
        $this->Redes_Sociales = $Redes_Sociales;
        $this->Minutos_LDI = $Minutos_LDI;
        $this->Cantidad_LDI = $Cantidad_LDI;
        $this->Servicios_Adicionales = $Servicios_Adicionales;
        $this->Cargo_Basico = $Cargo_Basico;
        $this->Grupo = $Grupo;
    }


    public function jsonSerialize()
    {
        return [
            "Id_Linea_Movil" => $this->Id_Linea_Movil,
            "Linea" => $this->Linea,
            "Minutos" => $this->Minutos,
            "Navegacion" => $this->Navegacion,
            "Mensajes" => $this->Mensajes,
            "Redes_Sociales" => $this->Redes_Sociales,
            "Minutos_LDI" => $this->Minutos_LDI,
            "Cantidad_LDI" => $this->Cantidad_LDI,
            "Servicios_Adicionales" => $this->Servicios_Adicionales,
            "Cargo_Basico" => $this->Cargo_Basico,
            "Grupo" => $this->Grupo
        ];
    }
}
