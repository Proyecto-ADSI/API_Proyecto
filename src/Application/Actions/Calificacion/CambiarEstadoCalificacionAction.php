<?php

declare(strict_types=1);

namespace App\Application\Actions\Calificacion;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoCalificacionAction extends CalificacionAction
{
    protected function action(): Response
    {
        $Id_Calificacion_Operador = $this->resolveArg("Id_Calificacion_Operador");
        $Estado = $this->resolveArg("Estado_Calificacion");

        $datos = $this->CalificacionRepository->CambiarEstado(intval($Id_Calificacion_Operador), intval($Estado));

        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

