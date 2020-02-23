<?php

declare(strict_types=1);

namespace App\Application\Actions\Sexo;

use App\Domain\Sexo\Sexo;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoSexo extends SexoAction
{
    protected function action(): Response
    {
        $Id_Sexo = $this->resolveArg("Id_Sexo");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->SexoRepository->CambiarEstado(intval($Id_Sexo), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

