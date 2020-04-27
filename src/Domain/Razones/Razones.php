<?php

declare(strict_types=1);

namespace App\Domain\Razones;

use JsonSerializable;

class Razones implements JsonSerializable{

    private $Id_Razon_Calificacion;
    private $Razon;
    private $Tipo_Razon;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(?int $Id_Razon_Calificacion, string $Razon, string $Tipo_Razon)
    {
        $this->Id_Razon_Calificacion = $Id_Razon_Calificacion;
        $this->Razon = $Razon;
        $this->Tipo_Razon = $Tipo_Razon;
    }

    public function jsonSerialize()
    {
       return [
        "Id_Razon_Calificacion" => $this->Id_Razon_Calificacion,
        "Razon" => $this->Razon,
        "Tipo_Razon" => $this->Tipo_Razon
       ];
    }


}