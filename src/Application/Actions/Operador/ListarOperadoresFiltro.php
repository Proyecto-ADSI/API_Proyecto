<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use Psr\Http\Message\ResponseInterface as Response;

class ListarOperadoresFiltro extends OperadorAction
{
    protected function action(): Response
    {   
        $parametros = $this->request->getQueryParams();

        $texto = $parametros['texto'];

        $Operador = $this->OperadorRepository->ListarOperadoresFiltro($texto);
        
        return $this->respondWithData($Operador);   
    }
}
