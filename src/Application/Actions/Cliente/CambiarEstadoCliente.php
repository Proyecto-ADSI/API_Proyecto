<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoCliente extends ClienteAction
{
    protected function action(): Response
    {
        $Id_Cliente = (int) $this->resolveArg('Id_Cliente_CE');

        $Estado = (int) $this->resolveArg('Estado');

        $respuesta = $this->ClienteRepository->CambiarEstadoCliente($Id_Cliente,$Estado);

        return $this->respondWithData($respuesta);

    }
}


