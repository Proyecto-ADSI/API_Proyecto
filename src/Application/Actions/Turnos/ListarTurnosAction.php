<?php

declare(strict_types=1);

  namespace App\Application\Actions\Turnos;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarTurnosAction extends TurnosAction
  {
   protected function action(): Response
   {
       $Turno = $this->TurnosRepository->ListarTurno();

       return $this->respondWithData($Turno);
   }
   
  }
