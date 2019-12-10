<?php 

declare(strict_types=1);

namespace App\Domain\Empleado;

use JsonSerializable;

class Empleado implements JsonSerializable
{
    private $Id_Empleado;
    private $Id_Usuario;
    private $Documento;
    private $Nombre;
    private $Apellido;
    private $Email;
    private $Sexo;
    private $Turno;
    
    public function __GET($attr){
        return $this->$attr;
    }

    function __construct(?int $Id_Empleado, int $Id_Usuario, string $Documento,string $Nombre, string $Apellido, string $Email,string $Sexo, string $Turno)
    {
        $this->Id_Empleado = $Id_Empleado;
        $this->Id_Usuario = $Id_Usuario;
        $this->Documento = $Documento;
        $this->Nombre = $Nombre;
        $this->Apellido = $Apellido;
        $this->Email = $Email;
        $this->Sexo = $Sexo;
        $this->Turno = $Turno;
    

    }

    public function jsonSerialize()
    {
        return[
            "Id_Empleado" => $this->Id_Empleado,
            "Id_Usuario" => $this->Id_Usuario,
            "Documento" => $this->Documento,
            "Nombre" => $this->Nombre,
            "Apellido" => $this->Apellido,
            "Email" => $this->Email,
            "Sexo" => $this->Sexo,
            "Turno" => $this->Turno
        ];    
    }
}