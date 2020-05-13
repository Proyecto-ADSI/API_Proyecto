<?php

declare(strict_types=1);

namespace App\Application\Actions\Razones;

use Psr\Http\Message\ResponseInterface as Response;

class EliminarRazonesAction extends RazonesAction
{
    protected function action(): Response
    {
        $Id_Razon_Calificacion = (int)$this->resolveArg("Id_Razon_Calificacion");

        $Eliminar = $this->RazonesRepository->EliminarRazones($Id_Razon_Calificacion);

        return $this->respondWithData(["Eliminar" => $Eliminar]);
        
    }
}

