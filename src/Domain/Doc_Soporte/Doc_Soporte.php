<?php 

declare(strict_types=1);

namespace App\Domain\Doc_Soporte;

use JsonSerializable;

class Doc_Soporte implements JsonSerializable{

    private $Id_Documentos;
    private $Camara_Comercio;
    private $Cedula_RL;
    private $Soporte_Ingresos;
    private $Detalles_Plan_Corporativo;


    public function __get($attr){
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(?int $Id_Documentos, string $Camara_Comercio, string $Cedula_RL, string $Soporte_Ingresos, string $Detalles_Plan_Corporativo)
    {
        $this->Id_Documentos = $Id_Documentos;
        $this->Camara_Comercio = $Camara_Comercio;
        $this->Cedula_RL = $Cedula_RL;
        $this->Soporte_Ingresos = $Soporte_Ingresos;
        $this->Detalles_Plan_Corporativo = $Detalles_Plan_Corporativo;
    }


    public function jsonSerialize()
    {
        return[
            "Id_Documentos" => $this->Id_Documentos,
            "Camara_Comercio" => $this->Camara_Comercio,
            "Cedula_RL" => $this->Cedula_RL,
            "Soporte_Ingresos" => $this->Soporte_Ingresos,
            "Detalles_Plan_Corporativo" => $this->Detalles_Plan_Corporativo,
        ];    
    }

}