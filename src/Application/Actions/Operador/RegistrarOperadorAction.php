<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Application\Actions\Operador\OperadorAction;
use App\Domain\Operador\Operador;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        // return $this->respondWithData(["ok"=> $campos]);

        $datos = new Operador(
            0,
            $campos->Nombre,
            $campos->Color,
            $campos->Estado,
        );
        
        $datos = $this->OperadorRepository->RegistrarOperador($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

