<?php

declare(strict_types=1);

namespace App\Application\Actions\BarriosVeredas;

use App\Domain\BarriosVeredas\BarriosVeredas;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarBarriosVeredasAction extends BarriosVeredasAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new BarriosVeredas(
            0,
            $campos->Codigo,
            $campos->Nombre,
            $campos->Id_SubTipo_Barrio_Vereda,
            $campos->Id_Municipio,
            $campos->Estado,
        );
        
        $datos = $this->BarriosVeredasRepository->RegistrarBarriosVeredas($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

