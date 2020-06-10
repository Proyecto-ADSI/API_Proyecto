<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use Psr\Http\Message\ResponseInterface as Response;

class ListarOpciones_PredefinidasAction extends Opciones_PredefinidasAction
{
   protected function action(): Response
   {
      $Opciones_Predefinidas = $this->Opciones_PredefinidasRepository->ListarOpcionesP();

      return $this->respondWithData($Opciones_Predefinidas);
   }
}
