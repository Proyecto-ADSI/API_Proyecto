<?php

declare(strict_types=1);

namespace App\Application\Actions\Sexo;

use App\Domain\Sexo\Sexo;
use Psr\Http\Message\ResponseInterface as Response;

class EditarSexoAction extends SexoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Sexo(
            $campos->Id_Sexo,
            $campos->Nombre,
            1
        );
        $datos = $this->SexoRepository->EditarSexo($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

