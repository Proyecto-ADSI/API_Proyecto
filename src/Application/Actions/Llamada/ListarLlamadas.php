<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use Psr\Http\Message\ResponseInterface as Response;

class ListarLlamadas extends LlamadaAction
{
    protected function action(): Response
    {
        $Llamadas = $this->LlamadaRepository->ListarLlamadas();
        return $this->respondWithData($Llamadas);
    }
}
