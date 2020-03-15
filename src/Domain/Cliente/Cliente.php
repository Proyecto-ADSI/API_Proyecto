<?php 

declare(strict_types=1);

namespace App\Domain\Cliente;

use JsonSerializable;

class Cliente implements JsonSerializable
{
    private $Id_Cliente;
    private $Id_DBL;
    private $NIT_CDV;
    private $Razon_Social;
    private $Telefono;
    private $Encargado;      
    private $Telefono_Contacto;   
    private $Extension;  
    private $Direccion;
    private $Id_Barrios_Veredas;
    private $Estado_Cliente;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(
        ?int $Id_Cliente,
        int $Id_DBL,
        string $NIT_CDV, 
        string $Razon_Social,
        string $Telefono,
        string $Encargado,
        string $Extension,
        string $Telefono_Contacto, 
        string $Direccion, 
        ?int $Id_Barrios_Veredas, 
        ?int $Estado_Cliente
    )
    {   
        $this->Id_Cliente = $Id_Cliente;
        $this->Id_DBL = $Id_DBL;
        $this->NIT_CDV = $NIT_CDV;
        $this->Razon_Social = $Razon_Social;
        $this->Telefono = $Telefono;
        $this->Encargado = $Encargado;
        $this->Extension = $Extension;
        $this->Telefono_Contacto = $Telefono_Contacto;
        $this->Direccion = $Direccion;
        $this->Id_Barrios_Veredas = $Id_Barrios_Veredas;
        $this->Estado_Cliente = $Estado_Cliente;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Cliente" => $this->Id_Cliente,
            "Id_DBL" => $this->Id_DBL,
            "NIT_CDV" => $this->NIT_CDV,
            "Razon_Social" => $this->Razon_Social,
            "Telefono" => $this->Telefono,
            "Encargado"=>$this->Encargado,
            "Extension"=>$this->Extension,
            "Telefono_Contacto"=>$this->Telefono_Contacto,
            "Direccion" => $this->Direccion,
            "Id_Barrios_Veredas" => $this->Id_Barrios_Veredas,
            "Estado_Cliente" => $this->Estado_Cliente,
        ];    
    }
}