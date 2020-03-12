<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Domain\Operador\Operador;
use Psr\Http\Message\ResponseInterface as Response;

class EditarOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Operador(
            $campos->Id_Operador,
            $campos->Nombre,
            null,
        );
        $datos = $this->OperadorRepository->EditarOperador($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

