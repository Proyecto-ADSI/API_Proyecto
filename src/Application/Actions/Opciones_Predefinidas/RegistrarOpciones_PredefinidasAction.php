<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use App\Application\Actions\Opciones_Predefinidas\Opciones_PredefinidasAction;
use App\Domain\Opciones_Predefinidas\Opciones_Predefinidas;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarOpciones_PredefinidasAction extends Opciones_PredefinidasAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Opciones_Predefinidas(
            NULL,
            $campos->Opcion,
            $campos->Categoria
        );

        $datos = $this->Opciones_PredefinidasRepository->RegistrarOpcionesP($datos);

        return $this->respondWithData(["ok" => $datos]);
    }
}
