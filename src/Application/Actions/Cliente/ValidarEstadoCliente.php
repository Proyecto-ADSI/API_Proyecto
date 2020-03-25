<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarEstadoCliente extends ClienteAction{

    protected function action(): Response
    {
        $Id_Cliente = (int) $this->resolveArg('Id_Cliente_VE');

        $Estado_Cliente = $this->ClienteRepository->ValidarEstadoCliente($Id_Cliente);

        return $this->respondWithData($Estado_Cliente);

    }

}