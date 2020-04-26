<?php

declare(strict_types=1);

  namespace App\Application\Actions\Calificacion;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarCalificacionAction extends CalificacionAction
  {
   protected function action(): Response
   {
       $Calificaciones = $this->CalificacionRepository->ListarCalificacion();

       return $this->respondWithData($Calificaciones);
   }
   
  }
