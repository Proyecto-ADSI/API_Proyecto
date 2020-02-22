<?php

declare(strict_types=1);

namespace App\Application\Actions\Municipio;

use App\Domain\Municipio\Municipio;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoMunicipioAction extends MunicipioAction
{
    protected function action(): Response
    {
        $Id_Municipio = $this->resolveArg("Id_Municipio");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->MunicipioRepository->CambiarEstado(intval($Id_Municipio), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

