<?php

declare(strict_types=1);

namespace App\Domain\Atencion_Telefonica;

interface AtencionTelefonicaRepository
{

    public function RegistrarAtencionTelefonica(AtencionTelefonica $AT);

    public function ListarAtencionTelefonica();

    public function ObtenerInfoAtencionTelefonica(int $Id_AT);
}
