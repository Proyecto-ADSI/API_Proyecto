<?php

declare(strict_types=1);

  namespace App\Application\Actions\Calificacion;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerCalificacionAction extends CalificacionAction
  {
   protected function action(): Response{
       $Id_Calificacion= $this->resolveArg("Id_Calificacion_Operador");

       $Calificacion = $this->CalificacionRepository->ObtenerDatosCalificacion($Id_Calificacion);

       return $this->respondWithData($Calificacion);
   }
   
  }
