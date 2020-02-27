<?php 

declare(strict_types=1);

namespace App\Domain\Plan_Corporativo;

class Plan_Corporativo{

    private $Id_Plan_Corporativo;
    private $Id_Documentos;
    private $Fecha_Inicio;
    private $Fecha_Fin;
    private $Descripcion;
    private $Estado_Plan_Corporativo;

    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Plan_Corporativo, ?int $Id_Documentos, string $Fecha_Inicio,
     string $Fecha_Fin, string $Descripcion, int $Estado_Plan_Corporativo)
    {
        $this->Id_Plan_Corporativo = $Id_Plan_Corporativo;
        $this->Id_Documentos = $Id_Documentos;
        $this->Fecha_Inicio = $Fecha_Inicio;
        $this->Fecha_Fin = $Fecha_Fin;
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
            "Descripcion" => $this->Descripcion,
            "Estado_Plan_Corporativo" => $this->Estado_Plan_Corporativo
        ];    
    }

}
