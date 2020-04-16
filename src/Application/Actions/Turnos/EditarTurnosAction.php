<?php

declare(strict_types=1);

namespace App\Application\Actions\Turnos;

use App\Domain\Turnos\Turnos;
use Psr\Http\Message\ResponseInterface as Response;

class EditarTurnosAction extends TurnosAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Turnos(
            $campos->Id_Turno,
            $campos->Nombre,
            $campos->Inicio,
            $campos->Fin,
            null
        );
        $datos = $this->TurnosRepository->EditarTurno($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

