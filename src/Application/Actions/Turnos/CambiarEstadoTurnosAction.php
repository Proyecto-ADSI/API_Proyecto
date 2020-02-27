<?php

declare(strict_types=1);

namespace App\Application\Actions\Turnos;

use App\Domain\Turnos\Turnos;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoTurnosAction extends TurnosAction
{
    protected function action(): Response
    {
        $Id_Turno = $this->resolveArg("Id_Turno");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->TurnosRepository->CambiarEstado(intval($Id_Turno), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

