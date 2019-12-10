<?php
declare(strict_types=1);

namespace App\Domain\Empleado;

interface EmpleadoRepository{

    public function registro(Empleado $empleado);

}