<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;
use Psr\Http\Message\ResponseInterface as Response;
class ListarCliente extends ClienteAction
{

    protected function action(): Response
    {
        $Clientes = $this->ClienteRepository->ListarCliente();
        
        return $this->respondWithData($Clientes);

    }

}

