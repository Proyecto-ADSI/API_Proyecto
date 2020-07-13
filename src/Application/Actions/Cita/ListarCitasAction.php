<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarCitasAction extends CitaAction
  {
   protected function action(): Response
   {
  
      $Citas = $this->CitaRepository->ListarCita();

      // foreach ($Citas as $Ids) {
      //    $Idss = (int)$Ids['Id_Cita'];

      //    $Citasss = $this->CitaRepository->ListarCita($Idss);
      // }

      return $this->respondWithData($Citas);
      
   }
  }
