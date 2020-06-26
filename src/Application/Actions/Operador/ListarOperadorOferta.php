<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use Psr\Http\Message\ResponseInterface as Response;

class ListarOperadorOferta extends OperadorAction
{
    protected function action(): Response
    {
        $Operador = $this->OperadorRepository->ListarOperadorOferta();

        return $this->respondWithData($Operador);
    }
}
