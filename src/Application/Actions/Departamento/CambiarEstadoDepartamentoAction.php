<?php

declare(strict_types=1);

namespace App\Application\Actions\Departamento;

use App\Domain\Departamento\Departamento;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoDepartamentoAction extends DepartamentoAction
{
    protected function action(): Response
    {
        $Id_Departamento = $this->resolveArg("Id_Departamento");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->DepartamentoRepository->CambiarEstado(intval($Id_Departamento), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

