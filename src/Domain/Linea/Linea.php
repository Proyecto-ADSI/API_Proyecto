<?php 

declare(strict_types=1);

namespace App\Domain\Linea;

use JsonSerializable;

class Linea implements JsonSerializable
{

    private $Id_Linea;     
    private $Linea;     
    private $Minutos;    
    private $Navegacion;    
    private $Mensajes;    
    private $Redes_Sociales;    
    private $Llamadas_Inter;    
    private $Roaming;       
    private $Cargo_Basico;    
    private $Grupo;    

     public function __GET($attr){
        return $this->$attr;
    }   

    function __construct(
        ?int $Id_Linea,
        ?string $Linea,
        ?string $Minutos,
        ?string $Navegacion,
        ?int $Mensajes,
        ?int $Redes_Sociales,
        ?int $Llamadas_Inter,
        ?int $Roaming,
        ?string $Cargo_Basico,
        ?int $Grupo

        ) 
    {
        $this->Id_Linea = $Id_Linea;
        $this->Linea = $Linea;
        $this->Minutos = $Minutos;
        $this->Navegacion = $Navegacion;
        $this->Mensajes = $Mensajes;
        $this->Redes_Sociales = $Redes_Sociales;
        $this->Llamadas_Inter = $Llamadas_Inter;
        $this->Roaming = $Roaming;
        $this->Cargo_Basico = $Cargo_Basico;
        $this->Grupo = $Grupo;
    }


    public function jsonSerialize()
    {
        return [
            "Id_Linea"=>$this->Id_Linea,
            "Linea"=>$this->Linea,
            "Minutos"=>$this->Minutos,
            "Navegacion"=>$this->Navegacion,
            "Mensajes"=>$this->Mensajes,
            "Redes_Sociales"=>$this->Redes_Sociales,
            "Llamadas_Inter"=>$this->Llamadas_Inter,
            "Roaming"=>$this->Roaming,
            "Cargo_Basico"=>$this->Cargo_Basico,
            "Grupo"=>$this->Grupo
        ];
    }
}