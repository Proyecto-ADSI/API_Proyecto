<?php

declare(strict_types=1);

namespace App\Domain\Empleado;

interface EmpleadoRepository
{
    public function ListarEmpleados();

    public function FiltrarEmpleados(string $texto);

    public function ListarRoles();

    public function ConsultarEmpleado(int $id);

    public function ConsultarUltimoEmpleado();

    public function RegistrarEmpleado(Empleado $empleado);

    public function EditarEmpleado(Empleado $empleado);

    public function EditarEmpleadoAE(Empleado $empleado);

    public function ValidarEmpleado(string $documento);

    public function ValidarCorreo(int $Empleado);
}
