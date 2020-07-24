<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarAsesoresExternos extends CitaAction
  {
   protected function action(): Response
   {
  
      $parametro = $this->request->getQueryParams();
   
      if ($parametro != NULL) {
         
         $AsesoresExternos = $this->CitaRepository->FiltrarAsesoresEx($parametro['palabra']);

         return $this->respondWithData(["results" => $AsesoresExternos]);

      } else {
         
         $AsesoresExternos = $this->CitaRepository->ListarAsesoresExternos();

         
         return $this->respondWithData(["results" => $AsesoresExternos]);

      }
   }
  }
