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
    private $Departamento;
    private $Municipio;
    private $Barrio_Vereda;
    private $Nombre_Lugar;
    private $Estado_Cliente;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(
        ?int $Id_Cliente, string $NIT_CDV, string $Razon_Social,string $Telefono, 
        string $Direccion, string $Departamento, string $Municipio, string $Barrio_Vereda, 
        string $Nombre_Lugar, int $Estado_Cliente
    )
    {   
        $this->Id_Cliente = $Id_Cliente;
        $this->NIT_CDV = $NIT_CDV;
        $this->Razon_Social = $Razon_Social;
        $this->Telefono = $Telefono;
        $this->Direccion = $Direccion;
        $this->Departamento = $Departamento;
        $this->Municipio = $Municipio;
        $this->Barrio_Vereda = $Barrio_Vereda;
        $this->Nombre_Lugar = $Nombre_Lugar;
        $this->Estado_Cliente = $Estado_Cliente;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Cliente" => $this->Id_Cliente,
            "NIT_CDV" => $this->NIT_CDV,
            "Razon_Social" => $this->Razon_Social,
            "Telefono" => $this->Telefono,
            "Direccion" => $this->Direccion,
            "Departamento" => $this->Departamento,
            "Municipio" => $this->Municipio,
            "Barrio_Vereda" => $this->Barrio_Vereda,
            "Nombre_Lugar" => $this->Nombre_Lugar,
            "Estado_Cliente" => $this->Estado_Cliente,
        ];    
    }
}