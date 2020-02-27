<?php

declare(strict_types=1);

namespace App\Application\Actions\SubTipo;

use App\Domain\SubTipo\SubTipo;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarSubTipoAction extends SubTipoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new SubTipo (
            0,
            $campos->SubTipo,
            $campos->Estado
        );
        
        $datos = $this->SubTipoRepository->RegistrarSubTipo($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

