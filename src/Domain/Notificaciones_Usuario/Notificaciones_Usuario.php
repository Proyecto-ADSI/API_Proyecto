<?php

declare (strict_types = 1);

namespace App\Domain\Notificaciones_Usuario;

use JsonSerializable;

class Notificaciones_Usuario implements JsonSerializable
{
    private $Id_NU;

    private $Id_Usuario;

    private $Id_Notificacion;

    private $Estado_Notificacion;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct(?int $Id_NU, int $Id_Usuario,int $Id_Notificacion, ?int $Estado_Notificacion)
    {
        $this->Id_NU = $Id_NU;
        $this->Id_Usuario = $Id_Usuario;
        $this->Id_Notificacion = $Id_Notificacion;
        $this->Estado_Notificacion = $Estado_Notificacion;
    }

    public function jsonSerialize()
    {
        return [
            "Id_NU" => $this->Id_NU,
            "Id_Usuario" => $this->Id_Usuario,
            "Id_Notificacion" => $this->Id_Notificacion,
            "Estado_Notificacion" => $this->Estado_Notificacion
        ];
    }
}
