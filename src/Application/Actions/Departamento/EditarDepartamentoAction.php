<?php

declare(strict_types=1);

namespace App\Application\Actions\Departamento;

use App\Domain\Departamento\Departamento;
use Psr\Http\Message\ResponseInterface as Response;

class EditarDepartamentoAction extends DepartamentoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Departamento(
            $campos->Id_Departamento,
            $campos->Nombre,
            $campos->Id_Pais,
            1
        );
        $datos = $this->DepartamentoRepository->EditarDepartamento($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

