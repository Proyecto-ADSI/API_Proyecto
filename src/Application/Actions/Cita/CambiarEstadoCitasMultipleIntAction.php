<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use App\Application\Actions\Cita\CitaAction;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoCitasMultipleIntAction extends CitaAction
{
    protected function action(): Response
    {
         $campos = $this->getFormData();


         foreach ($campos as $Citas) {
            $Id_Cita = (int) $Citas->Id_Cita;
            $EstadoInt = $Citas->Estado;
            $DataInt = $this->CitaRepository->CambiarEstadoRC($Id_Cita,$EstadoInt);
         }

        return $this->respondWithData($DataInt);

    }
}