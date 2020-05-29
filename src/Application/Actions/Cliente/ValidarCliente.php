<?php

declare (strict_types = 1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarCliente extends ClienteAction
{
    protected function action(): Response
    {
        $texto = $this->request->getQueryParams();

        $res = $this->ClienteRepository->ValidarCliente($texto['texto']);

        if ($res) {
            $Id_Cliente = (int) $res['Id_Cliente'];
            $cliente = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
            return $this->respondWithData(["ok" => false, "cliente" => $cliente]);
        } else {
            return $this->respondWithData(["ok" => true]);
        }
    }
}
