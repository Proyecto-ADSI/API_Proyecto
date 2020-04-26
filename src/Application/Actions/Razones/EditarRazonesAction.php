<?php

declare(strict_types=1);

namespace App\Application\Actions\Razones;

use App\Domain\Razones\Razones;
use Psr\Http\Message\ResponseInterface as Response;

class EditarRazonesAction extends RazonesAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Razones(
            $campos->Id_Razon_Calificacion,
            $campos->Razon
        );
        
        $datos = $this->RazonesRepository->EditarRazones($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

