<?php

declare(strict_types=1);

namespace App\Application\Actions\Departamento;

use App\Domain\Departamento\Departamento;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarDepartamentoAction extends DepartamentoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Departamento(
            0,
            $campos->Nombre,
            $campos->Id_Pais,
            $campos->Estado,
        );
        
        $datos = $this->DepartamentoRepository->RegistrarDepartamento($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

