<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarAsesoresExternos extends CitaAction
  {
   protected function action(): Response
   {
  
      $AsesoresExternos = $this->CitaRepository->ListarAsesoresExternos();

      return $this->respondWithData($AsesoresExternos);
   }
  }
