<?php

declare(strict_types=1);

namespace App\Application\Actions\Rol;

use App\Domain\Rol\Rol;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoRolAction extends RolAction
{
    protected function action(): Response
    {
        $Id_Rol = $this->resolveArg("Id_Rol");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->RolRepository->CambiarEstado(intval($Id_Rol), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

