<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarCitaSinAsignarAction extends CitaAction
  {
   protected function action(): Response
   {
  
      $CitasSinAsignar = $this->CitaRepository->ListarCitaSinAsignar();

      return $this->respondWithData($CitasSinAsignar);
   }
  }
