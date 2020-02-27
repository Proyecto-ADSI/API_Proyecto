<?php

declare(strict_types=1);

namespace App\Application\Actions\Turnos;

use App\Domain\Turnos\Turnos;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarTurnosAction extends TurnosAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Turnos(
            0,
            $campos->Nombre,
            $campos->Inicio,
            $campos->Fin,
            $campos->Estado,
        );
        
        $datos = $this->TurnosRepository->RegistrarTurnos($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

