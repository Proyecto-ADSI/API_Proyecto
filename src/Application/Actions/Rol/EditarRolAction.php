<?php

declare(strict_types=1);

namespace App\Application\Actions\Rol;

use App\Domain\Rol\Rol;
use Psr\Http\Message\ResponseInterface as Response;

class EditarRolAction extends RolAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

       
        $datos = new Rol(
            $campos->Id_Rol,
            $campos->Nombre,
            $campos->Estado,
            
        );
        $datos = $this->RolRepository->EditarRol($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

