<?php 

declare(strict_types=1);

namespace App\Domain\Plan_Corporativo;

use JsonSerializable;

class Plan_Corporativo implements JsonSerializable{

    private $Id_Plan_Corporativo;
    private $Id_Documentos;
    private $Fecha_Inicio;
    private $Fecha_Fin;
    private $Clausula_Permanencia;
    private $Descripcion;
    private $Estado_Plan_Corporativo;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    function __construct(
    ?int $Id_Plan_Corporativo, 
    ?int $Id_Documentos, 
    ?string $Fecha_Inicio,
    ?string $Fecha_Fin, 
    ?int $Clausula_Permanencia,
    ?string $Descripcion, 
    ?int $Estado_Plan_Corporativo)
    {
        $this->Id_Plan_Corporativo = $Id_Plan_Corporativo;
        $this->Id_Documentos = $Id_Documentos;
        $this->Fecha_Inicio = $Fecha_Inicio;
        $this->Fecha_Fin = $Fecha_Fin;
        $this->Clausula_Permanencia = $Clausula_Permanencia;
        $this->Descripcion = $Descripcion;
        $this->Estado_Plan_Corporativo = $Estado_Plan_Corporativo;
    }


    public function jsonSerialize()
    {
        return[
            "Id_Plan_Corporativo" => $this->Id_Plan_Corporativo,
            "Id_Documentos" => $this->Id_Documentos,
            "Fecha_Inicio" => $this->Fecha_Inicio,
            "Fecha_Fin" => $this->Fecha_Fin,
            "Clausula_Permanencia" => $this->Clausula_Permanencia,
            "Descripcion" => $this->Descripcion,
            "Estado_Plan_Corporativo" => $this->Estado_Plan_Corporativo
        ];    
    }

}
