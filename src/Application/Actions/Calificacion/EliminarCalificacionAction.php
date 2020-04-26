<?php

declare(strict_types=1);

namespace App\Application\Actions\Calificacion;

use Psr\Http\Message\ResponseInterface as Response;

class EliminarCalificacionAction extends CalificacionAction
{
    protected function action(): Response
    {
        $Id_Calificacion = (int)$this->resolveArg("Id_Calificacion");

        $Validar = $this->CalificacionRepository->ValidarEliminarCalificacion($Id_Calificacion);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
            
        }else{

           $Eliminar = $this->CalificacionRepository->EliminarCalificacion($Id_Calificacion);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

