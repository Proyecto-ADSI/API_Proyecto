<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarAsesoresInternosAction extends CitaAction
  {
   protected function action(): Response
   {
  
      $AsesoresInternos = $this->CitaRepository->ListarAsesoresInternos();

      return $this->respondWithData($AsesoresInternos);
   }
  }
