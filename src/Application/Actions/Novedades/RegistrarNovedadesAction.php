<?php

declare(strict_types=1);

namespace App\Application\Actions\Novedades;

use App\Application\Actions\Novedades\NovedadesAction;
use App\Domain\Novedades\Novedades;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarNovedadesAction extends NovedadesAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Novedades(
            null,
            $campos->Descripcion,
            $campos->Estado_Novedad,
            $campos->Id_Cita,
        );
        
        $datos = $this->NovedadesRepository->RegistrarNovedad($datos);
        
        // return $this->respondWithData($campos);
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

