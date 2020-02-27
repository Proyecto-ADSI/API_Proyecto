<?php

declare(strict_types=1);

namespace App\Application\Actions\BarriosVeredas;

use App\Domain\BarriosVeredas\BarriosVeredas;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoBarriosVeredasAction extends BarriosVeredasAction
{
    protected function action(): Response
    {
        $Id_Barrios_Veredas = $this->resolveArg("Id_Barrios_Veredas");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->BarriosVeredasRepository->CambiarEstado(intval($Id_Barrios_Veredas), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

