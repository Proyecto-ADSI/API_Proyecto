<?php

declare(strict_types=1);

namespace App\Application\Actions\SubTipo;
use App\Domain\SubTipo\SubTipo;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoSubTipoAction extends SubTipoAction
{
    protected function action(): Response
    {
        $Id_SubTipo_Barrio_Vereda = $this->resolveArg("Id_SubTipo_Barrio_Vereda");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->SubTipoRepository->CambiarEstado(intval($Id_SubTipo_Barrio_Vereda), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

