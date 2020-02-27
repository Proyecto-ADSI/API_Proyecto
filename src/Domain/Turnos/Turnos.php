<?php 

declare(strict_types=1);

namespace App\Domain\Turnos;

use JsonSerializable;

class Turnos implements JsonSerializable
{
    private $Id_Turno;

    private $Nombre;

    private $Inicio;

    private $Fin;

    private $Estado;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(int $Id_Turno, string $Nombre,string $Inicio, string $Fin, int $Estado)
    {   
        $this->Id_Turno = $Id_Turno;
        $this->Nombre = $Nombre;
        $this->Inicio = $Inicio;
        $this->Fin = $Fin;
        $this->Estado = $Estado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Turno" => $this->Id_Turno,
            "Nombre" => $this->Nombre,
            "Inicio" => $this->Inicio,
            "Fin" =>$this->Fin,
            "Estado"=>$this->Estado
        ];    
    }
}