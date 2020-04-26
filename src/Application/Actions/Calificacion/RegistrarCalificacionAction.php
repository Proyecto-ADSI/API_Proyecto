<?php

declare(strict_types=1);

namespace App\Application\Actions\Calificacion;

use App\Application\Actions\Calificacion\CalificacionAction;
use App\Domain\Calificacion\Calificacion;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarCalificacionAction extends CalificacionAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        // return $this->respondWithData(["ok"=> $campos]);

        $datos = new Calificacion(
            NULL,
            $campos->Calificacion,
            NULL,
        );
        
        $datos = $this->CalificacionRepository->RegistrarCalificacion($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

