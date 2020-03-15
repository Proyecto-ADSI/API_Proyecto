<?php 

declare(strict_types=1);

namespace App\Domain\DBL;

use JsonSerializable;

class DBL implements JsonSerializable
{

    private $Id_DBL;     
    private $Id_Operador;    
    private $Id_Plan_Corporativo;    
    private $Cantidad_Lineas;    
    private $Valor_Mensual;    
    private $Cantidad_Minutos;    
    private $Cantidad_Navegacion;    
    private $Llamadas_Internacionales;    
    private $Mensajes_Texto;    
    private $Aplicaciones;    
    private $Roaming_Internacional;    
    private $Estado_DBL;    

     public function __GET($attr){
        return $this->$attr;
    }   

    function __construct(
        ?int $Id_DBL,
        int $Id_Operador,
        ?int $Id_Plan_Corporativo,
        int $Cantidad_Lineas,
        string $Valor_Mensual,
        string $Cantidad_Minutos,
        string $Cantidad_Navegacion,
        string $Llamadas_Internacionales,
        string $Mensajes_Texto,
        string $Aplicaciones,
        string $Roaming_Internacional,
        ?int $Estado_DBL
        ) 
    {
        $this->Id_DBL = $Id_DBL;
        $this->Id_Operador = $Id_Operador;
        $this->Id_Plan_Corporativo = $Id_Plan_Corporativo;
        $this->Cantidad_Lineas = $Cantidad_Lineas;
        $this->Valor_Mensual = $Valor_Mensual;
        $this->Cantidad_Minutos = $Cantidad_Minutos;
        $this->Cantidad_Navegacion = $Cantidad_Navegacion;
        $this->Llamadas_Internacionales = $Llamadas_Internacionales;
        $this->Mensajes_Texto = $Mensajes_Texto;
        $this->Aplicaciones = $Aplicaciones;
        $this->Roaming_Internacional = $Roaming_Internacional;
        $this->Estado_DBL = $Estado_DBL;
    }


    public function jsonSerialize()
    {
        return [
            "Id_DBL"=>$this->Id_DBL,
            "Id_Operador"=>$this->Id_Operador,
            "Id_Plan_Corporativo"=>$this->Id_Plan_Corporativo,
            "Cantidad_Lineas"=>$this->Cantidad_Lineas,
            "Valor_Mensual"=>$this->Valor_Mensual,
            "Cantidad_Minutos"=>$this->Cantidad_Minutos,
            "Cantidad_Navegacion"=>$this->Cantidad_Navegacion,
            "Llamadas_Internacionales"=>$this->Llamadas_Internacionales,
            "Mensajes_Texto"=>$this->Mensajes_Texto,
            "Aplicaciones"=>$this->Aplicaciones,
            "Roaming_Internacional"=>$this->Roaming_Internacional,
            "Estado_DBL"=>$this->Estado_DBL
        ];
    }
}