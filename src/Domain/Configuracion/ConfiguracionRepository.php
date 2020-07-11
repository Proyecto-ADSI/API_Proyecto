<?php

declare(strict_types=1);

namespace App\Domain\Configuracion;

interface ConfiguracionRepository
{
    public function ListarConfiguracion();

    public function ModificarCampoConfiguracion(string $campo, $valor);

    public function CrearEventoHabilitar(int $Id_Cliente, string $Fecha_Control);

    // public function EliminarEventoHabilitar(int $Id_Cliente);
}
