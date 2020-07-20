<?php

declare(strict_types=1);

namespace App\Domain\Oferta;

use JsonSerializable;

class Oferta_P implements JsonSerializable
{
    private $Id_OP;

    private $Id_Oferta;

    private $Id_Corporativo_Anterior;

    private $Id_Corporativo_Actual;

    private $Basico_Neto_Operador1;

    private $Basico_Neto_Operador2;

    private $Valor_Neto_Operador1;

    private $Valor_Bruto_Operador2;

    private $Bono_Activacion;

    private $Valor_Neto_Operador2;

    private $Total_Ahorro;

    private $Reduccion_Anual;

    private $Valor_Mes_Promedio;

    private $Ahorro_Mensual_Promedio;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __construct(
        ?int $Id_OP,
        int $Id_Oferta,
        int $Id_Corporativo_Anterior,
        int $Id_Corporativo_Actual,
        string $Basico_Neto_Operador1,
        string $Basico_Neto_Operador2,
        string $Valor_Neto_Operador1,
        string $Valor_Bruto_Operador2,
        string $Bono_Activacion,
        string $Valor_Neto_Operador2,
        string $Total_Ahorro,
        string $Reduccion_Anual,
        string $Valor_Mes_Promedio,
        string $Ahorro_Mensual_Promedio
    ) {
        $this->Id_OP = $Id_OP;
        $this->Id_Oferta = $Id_Oferta;
        $this->Id_Corporativo_Anterior = $Id_Corporativo_Anterior;
        $this->Id_Corporativo_Actual = $Id_Corporativo_Actual;
        $this->Basico_Neto_Operador1 = $Basico_Neto_Operador1;
        $this->Basico_Neto_Operador2 = $Basico_Neto_Operador2;
        $this->Valor_Neto_Operador1 = $Valor_Neto_Operador1;
        $this->Valor_Bruto_Operador2 = $Valor_Bruto_Operador2;
        $this->Bono_Activacion = $Bono_Activacion;
        $this->Valor_Neto_Operador2 = $Valor_Neto_Operador2;
        $this->Total_Ahorro = $Total_Ahorro;
        $this->Reduccion_Anual = $Reduccion_Anual;
        $this->Valor_Mes_Promedio = $Valor_Mes_Promedio;
        $this->Ahorro_Mensual_Promedio = $Ahorro_Mensual_Promedio;
    }

    public function jsonSerialize()
    {
        return [
            "Id_OP" => $this->Id_OP,
            "Id_Oferta" => $this->Id_Oferta,
            "Id_Corporativo_Anterior" => $this->Id_Corporativo_Anterior,
            "Id_Corporativo_Actual" => $this->Id_Corporativo_Actual,
            "Basico_Neto_Operador1" => $this->Basico_Neto_Operador1,
            "Basico_Neto_Operador2" => $this->Basico_Neto_Operador2,
            "Valor_Neto_Operador1" => $this->Valor_Neto_Operador1,
            "Valor_Bruto_Operador2" => $this->Valor_Bruto_Operador2,
            "Bono_Activacion" => $this->Bono_Activacion,
            "Valor_Neto_Operador2" => $this->Valor_Neto_Operador2,
            "Total_Ahorro" => $this->Total_Ahorro,
            "Reduccion_Anual" => $this->Reduccion_Anual,
            "Valor_Mes_Promedio" => $this->Valor_Mes_Promedio,
            "Ahorro_Mensual_Promedio" => $this->Ahorro_Mensual_Promedio,
        ];
    }
}
