<?php

declare(strict_types=1);

namespace App\Application\Actions\Calificacion;

use App\Domain\Calificacion\Calificacion;
use Psr\Http\Message\ResponseInterface as Response;

class EditarCalificacionAction extends CalificacionAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Calificacion(
            $campos->Id_Calificacion_Operador,
            $campos->Calificacion,
            NULL,
        );
        $datos = $this->CalificacionRepository->EditarCalificacion($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

