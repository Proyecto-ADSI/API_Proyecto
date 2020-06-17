<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use Psr\Http\Message\ResponseInterface as Response;

class EmpleadoDisponible extends EmpleadoAction
{
    protected function action(): Response
    {
        $Empleado  = $this->request->getQueryParams();

        $respuesta = $this->EmpleadoRepository->ValidarEmpleado($Empleado['txtDocumento']);

        if ($respuesta) {
            return $this->respondWithData(false);
        } else {
            return $this->respondWithData(true);
        }
    }
}
