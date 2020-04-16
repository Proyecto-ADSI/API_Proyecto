<?php 

declare(strict_types=1);

namespace App\Domain\Cliente;
use JsonSerializable;

class ClienteImportado implements JsonSerializable
{
    private $Id_Importar_Cliente;
    private $NIT_CDV;
    private $Razon_Social;
    private $Telefono;
    private $Encargado; 
    private $Ext_Tel_Contacto; 
    private $Direccion;
    private $Municipio;
    private $Barrio;
    private $Tiene_PC;
    private $Operador_Actual;
    private $Cantidad_Total_Lineas; 
    private $Valor_Total_Mensual; 
    private $Fecha_Inicio; 
    private $Fecha_Fin; 
    private $Clausula_Permanencia; 
    private $Descripcion;
    private $Estado_Cliente_Importado; 
          
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(
        ?int $Id_Importar_Cliente,
        $NIT_CDV, 
        $Razon_Social,
        $Telefono,
        $Encargado,
        $Ext_Tel_Contacto,
        $Direccion, 
        $Municipio, 
        $Barrio, 
        $Tiene_PC, 
        $Operador_Actual, 
        $Cantidad_Total_Lineas, 
        $Valor_Total_Mensual, 
        $Fecha_Inicio, 
        $Fecha_Fin, 
        $Clausula_Permanencia, 
        $Descripcion,
        ?int $Estado_Cliente_Importado
        
    )
    {   
        $this->Id_Importar_Cliente = $Id_Importar_Cliente;
        $this->NIT_CDV = $NIT_CDV;
        $this->Razon_Social = $Razon_Social;
        $this->Telefono = $Telefono;
        $this->Encargado = $Encargado;
        $this->Ext_Tel_Contacto = $Ext_Tel_Contacto;
        $this->Direccion = $Direccion;
        $this->Municipio = $Municipio;
        $this->Barrio = $Barrio;
        $this->Tiene_PC = $Tiene_PC;
        $this->Operador_Actual = $Operador_Actual;
        $this->Cantidad_Total_Lineas = $Cantidad_Total_Lineas;
        $this->Valor_Total_Mensual = $Valor_Total_Mensual;
        $this->Fecha_Inicio = $Fecha_Inicio;
        $this->Fecha_Fin = $Fecha_Fin;
        $this->Clausula_Permanencia = $Clausula_Permanencia;
        $this->Descripcion = $Descripcion;
        $this->Estado_Cliente_Importado = $Estado_Cliente_Importado;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Importar_Cliente" => $this->Id_Importar_Cliente,
            "NIT_CDV" => $this->NIT_CDV,
            "Razon_Social" => $this->Razon_Social,
            "Telefono" => $this->Telefono,
            "Encargado" => $this->Encargado,
            "Ext_Tel_Contacto"=>$this->Ext_Tel_Contacto,
            "Direccion"=>$this->Direccion,
            "Municipio"=>$this->Municipio,
            "Barrio"=>$this->Barrio,
            "Tiene_PC" => $this->Tiene_PC,
            "Operador_Actual" => $this->Operador_Actual,
            "Cantidad_Total_Lineas" => $this->Cantidad_Total_Lineas,
            "Valor_Total_Mensual" => $this->Valor_Total_Mensual,
            "Fecha_Inicio" => $this->Fecha_Inicio,
            "Fecha_Fin" => $this->Fecha_Fin,
            "Clausula_Permanencia" => $this->Clausula_Permanencia,
            "Descripcion" => $this->Descripcion,
            "Estado_Cliente_Importado" => $this->Estado_Cliente_Importado
        ];    
    }
}