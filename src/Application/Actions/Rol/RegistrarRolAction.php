<?php

declare(strict_types=1);

namespace App\Application\Actions\Rol;

use App\Domain\Rol\Rol;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarRolAction extends RolAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Rol(
            0,
            $campos->Nombre,
            $campos->Estado
        );
        
        $datos = $this->RolRepository->RegistrarRol($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

