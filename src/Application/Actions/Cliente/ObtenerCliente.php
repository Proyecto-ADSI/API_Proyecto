<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerCliente extends ClienteAction
{
    protected function action(): Response
    {

        $Id_Cliente = (int) $this->resolveArg("Id_Cliente");

        $Cliente = $this->ClienteRepository->ObtenerCliente($Id_Cliente);

        return  $this->respondWithData($Cliente);
    }
}