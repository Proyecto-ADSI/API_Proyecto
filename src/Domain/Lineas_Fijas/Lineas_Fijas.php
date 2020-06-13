<?php

declare(strict_types=1);

namespace App\Domain\Lineas_Fijas;

use JsonSerializable;

class Lineas_Fijas implements JsonSerializable
{

    private $Id_Linea_Fija;
    private $Pagina_Web;
    private $Correo_Electronico;
    private $IP_Fija;
    private $Dominio;
    private $Telefonia;
    private $Television;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_Linea_Fija,
        ?int $Pagina_Web,
        ?int $Correo_Electronico,
        ?int $IP_Fija,
        ?int $Dominio,
        ?int $Telefonia,
        ?int $Television

    ) {
        $this->Id_Linea_Fija = $Id_Linea_Fija;
        $this->Pagina_Web = $Pagina_Web;
        $this->Correo_Electronico = $Correo_Electronico;
        $this->IP_Fija = $IP_Fija;
        $this->Dominio = $Dominio;
        $this->Telefonia = $Telefonia;
        $this->Television = $Television;
    }


    public function jsonSerialize()
    {
        return [
            "Id_Linea_Fija" => $this->Id_Linea_Fija,
            "Pagina_Web" => $this->Pagina_Web,
            "Correo_Electronico" => $this->Correo_Electronico,
            "IP_Fija" => $this->IP_Fija,
            "Dominio" => $this->Dominio,
            "Telefonia" => $this->Telefonia,
            "Television" => $this->Television,
        ];
    }
}
