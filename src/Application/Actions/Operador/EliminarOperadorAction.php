<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

// use App\Domain\Documento\Documento;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $Id_Operador = (int) $this->resolveArg("Id_Operador");

        $arrayIdEliminar = $this->OperadorRepository->ValidarOperadorEliminar($Id_Operador);

        if (!empty($arrayIdEliminar)) {
            return $this->respondWithData(["Eliminar" => false]);
        } else {
            $Eliminar = $this->OperadorRepository->EliminarOperador($Id_Operador);
            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
    }
}
