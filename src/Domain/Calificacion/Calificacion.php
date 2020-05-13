<?php

declare(strict_types=1);

namespace App\Domain\Calificacion;

use JsonSerializable;

class Calificacion implements JsonSerializable{

    private $Id_Calificacion_Operador;
    private $Calificacion;
    private $Estado_Calificacion;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(?int $Id_Calificacion_Operador, string $Calificacion, ?int $Estado_Calificacion)
    {
        $this->Id_Calificacion_Operador = $Id_Calificacion_Operador;
        $this->Calificacion = $Calificacion;
        $this->Estado_Calificacion = $Estado_Calificacion;
    }

    public function jsonSerialize()
    {
       return [
        "Id_Calificacion_Operador" => $this->Id_Calificacion_Operador,
        "Calificacion" => $this->Calificacion,
        "Estado_Calificacion" => $this->Estado_Calificacion
       ];
    }


}