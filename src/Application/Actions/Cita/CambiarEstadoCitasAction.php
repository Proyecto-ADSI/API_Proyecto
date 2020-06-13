<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use App\Application\Actions\Cita\CitaAction;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoCitasAction extends CitaAction
{
    protected function action(): Response
    {
         $campos = $this->getFormData();

         $Id_Cita = (int) $campos->Id_Cita;
         $Estadovg = $campos->Estadovg;
         $Datavg = $this->CitaRepository->CambiarEstadoV($Id_Cita,$Estadovg);

        return $this->respondWithData($Datavg);

    }
}