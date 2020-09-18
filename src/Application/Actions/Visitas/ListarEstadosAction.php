<?php

declare (strict_types=1);

namespace App\Application\Actions\Visitas;
use Psr\Http\Message\ResponseInterface as Response;

class ListarEstadosAction extends VisitasAction {

    protected function action(): Response
    {
        $EstadosVisita = $this->VisitasRepository->ListarEstados();

        return $this->respondWithData($EstadosVisita);
    }
}