<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarCitasAction extends CitaAction
  {
   protected function action(): Response
   {
  
      $Citas = $this->CitaRepository->ListarCita();


      return $this->respondWithData($Citas);
      
   }
  }
