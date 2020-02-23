<?php

declare(strict_types=1);

namespace App\Application\Actions\Pais;

use App\Domain\Pais\Pais;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoPaisAction extends PaisAction
{
    protected function action(): Response
    {
        $Id_Pais = $this->resolveArg("Id_Pais");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->PaisRepository->CambiarEstado(intval($Id_Pais), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

