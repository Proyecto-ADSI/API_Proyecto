<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerOpciones_PredefinidasAction extends Opciones_PredefinidasAction
{
  protected function action(): Response
  {
    $Id_OP = (int) $this->resolveArg("Id_OP");

    $Opcion_Predefinida = $this->Opciones_PredefinidasRepository->ObtenerDatosOpcionesP($Id_OP);

    return $this->respondWithData($Opcion_Predefinida);
  }
}
