<?php

declare(strict_types=1);

namespace App\Domain\Empleado;

use JsonSerializable;

class Empleado implements JsonSerializable
{
    private $Id_Empleado;
    private $Tipo_Documento;
    private $Documento;
    private $Nombre;
    private $Apellidos;
    private $Email;
    private $Sexo;
    private $Celular;
    private $Imagen;
    private $Turno;
    private $Email_Valido;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Empleado,
        ?int $Tipo_Documento,
        ?string $Documento,
        string $Nombre,
        ?string $Apellidos,
        string $Email,
        ?int $Sexo,
        ?string $Celular,
        ?string $Imagen,
        ?int $Turno,
        ?int $Email_Valido
    ) {
        $this->Id_Empleado = $Id_Empleado;
        $this->Tipo_Documento = $Tipo_Documento;
        $this->Documento = $Documento;
        $this->Nombre = $Nombre;
        $this->Apellidos = $Apellidos;
        $this->Email = $Email;
        $this->Sexo = $Sexo;
        $this->Celular = $Celular;
        $this->Imagen = $Imagen;
        $this->Turno = $Turno;
        $this->Email_Valido = $Email_Valido;
    }

    public function jsonSerialize()
    {
        return [
            "Id_Empleado" => $this->Id_Empleado,
            "Tipo_Documento" => $this->Tipo_Documento,
            "Documento" => $this->Documento,
            "Nombre" => $this->Nombre,
            "Apellidos" => $this->Apellidos,
            "Email" => $this->Email,
            "Sexo" => $this->Sexo,
            "Celular" => $this->Celular,
            "Imagen" => $this->Imagen,
            "Turno" => $this->Turno,
            "Email_Valido" => $this->Email_Valido
        ];
    }
}
