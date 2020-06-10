<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use Psr\Http\Message\ResponseInterface as Response;

class EliminarOpciones_PredefinidasAction extends Opciones_PredefinidasAction
{
    protected function action(): Response
    {
        $Id_OP = (int) $this->resolveArg("Id_OP");

        $res = $this->Opciones_PredefinidasRepository->EliminarOopcionesP($Id_OP);

        return $this->respondWithData($res);
    }
}
