<?php

declare(strict_types=1);

namespace App\Application\Actions\Municipio;

use Psr\Http\Message\ResponseInterface as Response;

class ListarMunicipiosFiltro extends MunicipioAction
{
    protected function action(): Response
    {

        $texto = $this->resolveArg("Municipio");
        
        $data = $this->MunicipioRepository->ListarMunicipiosFiltro($texto);

        return $this->respondWithData($data);
    }
}
