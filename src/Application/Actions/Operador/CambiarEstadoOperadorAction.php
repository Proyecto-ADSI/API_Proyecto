<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Domain\Operador\Operador;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $Id_Operador = $this->resolveArg("Id_Operador");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->OperadorRepository->CambiarEstado(intval($Id_Operador), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

