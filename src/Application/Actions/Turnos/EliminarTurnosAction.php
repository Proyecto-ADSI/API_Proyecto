<?php

declare(strict_types=1);

namespace App\Application\Actions\Turnos;

use App\Application\Actions\Turnos\TurnosAction;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarTurnosAction extends TurnosAction
{
    protected function action(): Response
    {
        $Id_Turnos = (int)$this->resolveArg("Id_Turno");

        $Validar = $this->TurnosRepository->ValidarEliminarTurno($Id_Turnos);


        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $Eliminar = $this->TurnosRepository->EliminarTurno($Id_Turnos);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

