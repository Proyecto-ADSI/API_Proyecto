<?php 

declare(strict_types=1);

namespace App\Domain\Cita;

use JsonSerializable;

class Cita implements JsonSerializable
{   
    
    private $Id_Cita;
    private $Id_Llamada;
    private $Encargado_Cita;
    private $Ext_Tel_Contacto_Cita;
    private $Representante_Legal;
    private $Fecha_Cita;
    private $Duracion_Verificacion;
    private $Direccion;
    private $Id_Barrios_Veredas;
    private $Lugar_Referencia;
    private $Id_Operador;
    private $Factibilidad;
    private $Id_Coordinador;
    private $Id_Estado_Cita;
    
    
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Cita,
        int $Id_Llamada, 
        string $Encargado_Cita,
        string $Ext_Tel_Contacto_Cita,
        int $Representante_Legal,
        string $Fecha_Cita,
        string $Duracion_Verificacion,
        string $Direccion, 
        int $Id_Barrios_Veredas, 
        string $Lugar_Referencia, 
        int $Id_Operador, 
        ?string $Factibilidad, 
        ?int $Id_Coordinador, 
        int $Id_Estado_Cita
    )
    {   
        $this->Id_Cita = $Id_Cita;
        $this->Id_Llamada = $Id_Llamada;
        $this->Encargado_Cita = $Encargado_Cita;
        $this->Ext_Tel_Contacto_Cita = $Ext_Tel_Contacto_Cita;
        $this->Representante_Legal = $Representante_Legal;
        $this->Fecha_Cita = $Fecha_Cita;
        $this->Duracion_Verificacion = $Duracion_Verificacion;
        $this->Direccion = $Direccion;
        $this->Id_Barrios_Veredas = $Id_Barrios_Veredas;
        $this->Lugar_Referencia = $Lugar_Referencia;
        $this->Id_Operador = $Id_Operador;
        $this->Factibilidad = $Factibilidad;
        $this->Id_Coordinador = $Id_Coordinador;
        $this->Id_Estado_Cita = $Id_Estado_Cita;
    }

    public function jsonSerialize()
    {
        return[
            "Id_Cita" => $this->Id_Cita,
            "Id_Llamada" => $this->Id_Llamada,
            "Encargado_Cita" => $this->Encargado_Cita,
            "Ext_Tel_Contacto_Cita" => $this->Ext_Tel_Contacto_Cita,
            "Representante_Legal" => $this->Representante_Legal,
            "Fecha_Cita" => $this->Fecha_Cita,
            "Duracion_Verificacion" => $this->Duracion_Verificacion,
            "Direccion" => $this->Direccion,
            "Id_Barrios_Veredas" => $this->Id_Barrios_Veredas,
            "Lugar_Referencia" => $this->Lugar_Referencia,
            "Id_Operador" => $this->Id_Operador,
            "Factibilidad" => $this->Factibilidad,
            "Id_Coordinador" => $this->Id_Coordinador,
            "Id_Estado_Cita" => $this->Id_Estado_Cita
        ];    
    }
}