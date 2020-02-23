<?php

declare(strict_types=1);

  namespace App\Application\Actions\Pais;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosPaisAction extends PaisAction
  {
   protected function action(): Response
   {

       $Id_Pais= $this->resolveArg("Id_Pais");

       $Pais = $this->PaisRepository->ObtenerDatos($Id_Pais);

       return $this->respondWithData($Pais);
   }
   
  }
