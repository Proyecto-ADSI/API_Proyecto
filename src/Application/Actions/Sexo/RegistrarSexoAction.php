<?php

declare(strict_types=1);

namespace App\Application\Actions\Sexo;

use App\Domain\Sexo\Sexo;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarSexoAction extends SexoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Sexo(
            0,
            $campos->Nombre,
            $campos->Estado,
        );
        
        $datos = $this->SexoRepository->RegistrarSexo($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

