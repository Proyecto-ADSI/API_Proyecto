<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use Psr\Http\Message\ResponseInterface as Response;

class ListarOpciones_PredefinidasCategoria extends Opciones_PredefinidasAction
{
   protected function action(): Response
   {
      $Categoria = $this->resolveArg("Categoria");
      $Opciones_Predefinidas = $this->Opciones_PredefinidasRepository->ListarOpcionesPCategoria($Categoria);

      return $this->respondWithData($Opciones_Predefinidas);
   }
}
