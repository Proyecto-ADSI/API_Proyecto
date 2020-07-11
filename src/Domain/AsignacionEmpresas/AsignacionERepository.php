<?php

declare(strict_types=1);

namespace App\Domain\AsignacionEmpresas;

interface AsignacionERepository
{
    public function ValidarEmpresasAsignadas(int $Id_Usuario);

    public function ValidarEmpresaAsignadaContact(int $Id_Usuario, int $Id_Cliente);

    public function ObtenerCantidadEmpresasContact();

    public function ObtenerCantidadEmpresasRe_Asignables();

    public function ObtenerEmpresasContact(int $Id_Usuario, int $Id_Estado);

    public function SeleccionarEmpresasDisponibles(int $Cantidad);

    public function AsignarEmpresasContact(int $Id_Usuario, int $Id_Cliente);

    public function EliminarTodasEmpresasAsignadas(int $Id_Usuario);

    public function EliminarEmpresasAsignadasValidacion(int $Id_Usuario, int $Id_Cliente);

    public function EliminarEmpresaAsignada(int $Id_Usuario, int $Id_Cliente);

    public function SeleccionarEmpresaAsignada(int $Id_Usuario);

    public function CambiarEstadoAEnLlamada(int $Id_Cliente);
}
