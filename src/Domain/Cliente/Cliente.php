<?php 

declare(strict_types=1);

namespace App\Domain\Cliente;

use JsonSerializable;

class Cliente implements JsonSerializable
{
    private $Id_Cliente;
    private $NIT_CDV;
    private $Razon_Social;
    private $Telefono;
    private $Direccion;
    private $Id_Estado_Cliente;
    private $Departamento;
    private $Municipio;
    private $Barrio_Vereda;
    private $Nombre_Lugar;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Cliente, string $NIT_CDV, string $Razon_Social,string $Telefono, string $Direccion, int $Id_Estado_Cliente,$Email, string $Departamento, string $Municipio, string $Barrio_Vereda, string $Nombre_Lugar)
    {   
        $this->Id_Cliente = $Id_Cliente;
        $this->NIT_CDV = $NIT_CDV;
        $this->Razon_Social = $Razon_Social;
        $this->Telefono = $Telefono;
        $this->Direccion = $Direccion;
        $this->Id_Estado_Cliente = $Id_Estado_Cliente;
        $this->Departamento = $Departamento;
        $this->Municipio = $Municipio;
        $this->Barrio_Vereda = $Barrio_Vereda;
        $this->Nombre_Lugar = $Nombre_Lugar;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Cliente" => $this->Id_Cliente,
            "NIT_CDV" => $this->NIT_CDV,
            "Razon_Social" => $this->Razon_Social,
            "Telefono" => $this->Telefono,
            "Direccion" => $this->Direccion,
            "Id_Estado_Cliente" => $this->Id_Estado_Cliente,
            "Departamento" => $this->Departamento,
            "Municipio" => $this->Municipio,
            "Barrio_Vereda" => $this->Barrio_Vereda,
            "Nombre_Lugar" => $this->Nombre_Lugar
        ];    
    }
}