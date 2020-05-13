<?php

declare(strict_types=1);

  namespace App\Application\Actions\Razones;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerRazonesAction extends RazonesAction
  {
   protected function action(): Response{
       $Id_Razon_Calificacion = $this->resolveArg("Id_Razon_Calificacion");

       $Razon = $this->RazonesRepository->ObtenerDatosRazones($Id_Razon_Calificacion);

       return $this->respondWithData($Razon);
   }
   
  }
