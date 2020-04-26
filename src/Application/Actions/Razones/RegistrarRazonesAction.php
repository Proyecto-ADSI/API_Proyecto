<?php

declare(strict_types=1);

namespace App\Application\Actions\Razones;

use App\Application\Actions\Razones\RazonesAction;
use App\Domain\Razones\Razones;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarRazonesAction extends RazonesAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Razones(
            NULL,
            $campos->Razon
        );
        
        $datos = $this->RazonesRepository->RegistrarRazones($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

