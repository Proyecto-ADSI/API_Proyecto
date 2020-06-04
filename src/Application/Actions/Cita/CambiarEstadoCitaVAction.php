<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use App\Application\Actions\Cita\CitaAction;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoCitaVAction extends CitaAction
{
    protected function action(): Response
    {
        $Id_Cita = $this->resolveArg("Id_Cita");
        $EstadoV = $this->resolveArg("EstadoV");
       
        $datos = $this->CitaRepository->CambiarEstadoV(intval($Id_Cita), intval($EstadoV));

        return $this->respondWithData(["ok"=>$datos]);    
    }
}