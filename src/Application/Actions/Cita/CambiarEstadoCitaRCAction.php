<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;
  use App\Domain\Cita\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class CambiarEstadoCitaRCAction extends CitaAction
  {
   protected function action(): Response
   {  
      $campos = $this->getFormData();

      $Data = null;

      foreach($campos as $Cita){
          $Id = (int) $Cita->Id;
          $Estado = $Cita->Estado;

         $Data = $this->CitaRepository->CambiarEstadoRC($Id,$Estado);
      }

      
      return $this->respondWithData($Data);
  }
  }