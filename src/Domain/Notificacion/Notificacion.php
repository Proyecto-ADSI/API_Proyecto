<?php

declare (strict_types = 1);

namespace App\Domain\Notificacion;

use JsonSerializable;

class Notificacion implements JsonSerializable
{
    private $Id_Notificacion;

    private $Id_Usuario;

    private $Fecha;

    private $Mensaje;

    private $Id_Categoria_N;

    private $Id_Registro;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct(?int $Id_Notificacion, int $Id_Usuario, ?string $Fecha, string $Mensaje, int $Id_Categoria_N, int $Id_Registro)
    {
        $this->Id_Notificacion = $Id_Notificacion;
        $this->Id_Usuario = $Id_Usuario;
        $this->Fecha = $Fecha;
        $this->Mensaje = $Mensaje;
        $this->Id_Categoria_N = $Id_Categoria_N;
        $this->Id_Registro = $Id_Registro;
    }

    public function jsonSerialize()
    {
        return [
            "Id_Notificacion" => $this->Id_Notificacion,
            "Id_Usuario" => $this->Id_Usuario,
            "Fecha" => $this->Fecha,
            "Mensaje" => $this->Mensaje,
            "Id_Categoria_N" => $this->Id_Categoria_N,
            "Id_Registro" => $this->Id_Registro
        ];
    }
}
