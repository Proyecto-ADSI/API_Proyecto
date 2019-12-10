<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use App\Domain\Empleado\Empleado;
use Psr\Http\Message\ResponseInterface as Response;

class EmpleadoRegistro extends EmpleadoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Empleado(
            0,
            $campos->Id_Usuario,
            $campos->Documento,
            $campos->Nombre,
            $campos->Aplellido,
            $campos->Email,
            $campos->Sexo,
            $campos->Turno
        );
        
        $datos = $this->EmpleadoRepository->registro($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

