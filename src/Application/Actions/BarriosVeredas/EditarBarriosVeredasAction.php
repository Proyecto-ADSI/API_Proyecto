<?php

declare(strict_types=1);

namespace App\Application\Actions\BarriosVeredas;

use App\Domain\BarriosVeredas\BarriosVeredas;
use App\Domain\Departamento\Departamento;
use Psr\Http\Message\ResponseInterface as Response;

class EditarBarriosVeredasAction extends BarriosVeredasAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new BarriosVeredas(
            $campos->Id_Barrios_Veredas,
            $campos->Codigo,
            $campos->Nombre,
            $campos->Id_SubTipo_Barrio_Vereda,
            $campos->Id_Municipio,
            null
        );
        $datos = $this->BarriosVeredasRepository->EditarBarriosVeredas($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

