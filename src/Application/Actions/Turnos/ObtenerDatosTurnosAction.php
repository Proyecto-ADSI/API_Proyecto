<?php

declare(strict_types=1);

  namespace App\Application\Actions\Turnos;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosTurnosAction extends TurnosAction
  {
   protected function action(): Response
   {

       $Id_Turnos = $this->resolveArg("Id_Turno");

       $Turno = $this->TurnosRepository->ObtenerDatosTurno($Id_Turnos);

       return $this->respondWithData($Turno);
   }
   
  }
