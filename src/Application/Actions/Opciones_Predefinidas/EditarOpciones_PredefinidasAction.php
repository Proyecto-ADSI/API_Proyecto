<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use App\Domain\Opciones_Predefinidas\Opciones_Predefinidas;
use Psr\Http\Message\ResponseInterface as Response;

class EditarOpciones_PredefinidasAction extends Opciones_PredefinidasAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Opciones_Predefinidas(
            $campos->Id_OP,
            $campos->Opcion,
            $campos->Categoria
        );

        $datos = $this->Opciones_PredefinidasRepository->EditarOpcionesP($datos);

        return $this->respondWithData(["ok" => $datos]);
    }
}
