<?php

declare (strict_types=1);

namespace App\Application\Actions\Visitas;

use Psr\Http\Message\ResponseInterface as Reponse;

class CambiarEstadoVisitasAction extends VisitasAction{

    protected function action(): Reponse
    {

        $Campos = $this->getFormData();

        $Id_Visita = $Campos->Id_Visita;
        $Estado = $Campos->EstadoNuevo;

        $CambioEstado = $this->VisitasRepository->CambiarEstado($Id_Visita,$Estado);
    
        return $this->respondWithData(["Ok"=> $CambioEstado]);
    }
}