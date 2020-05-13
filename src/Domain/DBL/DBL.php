<?php 

declare(strict_types=1);

namespace App\Domain\DBL;

use JsonSerializable;

class DBL implements JsonSerializable
{

    private $Id_DBL;     
    private $Id_Cliente;     
    private $Id_Operador;    
    private $Id_Plan_Corporativo;    
    private $Cantidad_Total_Lineas;    
    private $Valor_Total_Mensual;    
    private $Id_Calificacion_Operador;    
    private $Razones;       
    private $Estado_DBL;    

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }   

    function __construct(
        ?int $Id_DBL,
        int $Id_Cliente,
        ?int $Id_Operador,
        ?int $Id_Plan_Corporativo,
        ?int $Cantidad_Total_Lineas,
        ?string $Valor_Total_Mensual,
        ?int $Id_Calificacion_Operador,
        ?string $Razones,
        ?int $Estado_DBL
        ) 
    {
        $this->Id_DBL = $Id_DBL;
        $this->Id_Cliente = $Id_Cliente;
        $this->Id_Operador = $Id_Operador;
        $this->Id_Plan_Corporativo = $Id_Plan_Corporativo;
        $this->Cantidad_Total_Lineas = $Cantidad_Total_Lineas;
        $this->Valor_Total_Mensual = $Valor_Total_Mensual;
        $this->Id_Calificacion_Operador = $Id_Calificacion_Operador;
        $this->Razones = $Razones;
        $this->Estado_DBL = $Estado_DBL;
    }


    public function jsonSerialize()
    {
        return [
            "Id_DBL"=>$this->Id_DBL,
            "Id_Cliente"=>$this->Id_Cliente,
            "Id_Operador"=>$this->Id_Operador,
            "Id_Plan_Corporativo"=>$this->Id_Plan_Corporativo,
            "Cantidad_Total_Lineas"=>$this->Cantidad_Total_Lineas,
            "Valor_Total_Mensual"=>$this->Valor_Total_Mensual,
            "Id_Calificacion_Operador"=>$this->Id_Calificacion_Operador,
            "Razones"=>$this->Razones,
            "Estado_DBL"=>$this->Estado_DBL
        ];
    }
}