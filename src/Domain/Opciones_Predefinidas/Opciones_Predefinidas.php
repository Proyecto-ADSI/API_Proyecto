<?php

declare(strict_types=1);

namespace App\Domain\Opciones_Predefinidas;

use JsonSerializable;

class Opciones_Predefinidas implements JsonSerializable
{

    private $Id_OP;
    private $Opcion;
    private $Categoria;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(?int $Id_OP, string $Opcion, string $Categoria)
    {
        $this->Id_OP = $Id_OP;
        $this->Opcion = $Opcion;
        $this->Categoria = $Categoria;
    }

    public function jsonSerialize()
    {
        return [
            "Id_OP" => $this->Id_OP,
            "Opcion" => $this->Opcion,
            "Categoria" => $this->Categoria
        ];
    }
}
