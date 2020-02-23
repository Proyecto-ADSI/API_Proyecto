<?php

declare(strict_types=1);

  namespace App\Application\Actions\Municipio;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosMunicipioAction extends MunicipioAction
  {
   protected function action(): Response
   {

       $Id_Municipio= $this->resolveArg("Id_Municipio");

       $Municipio = $this->MunicipioRepository->ObtenerDatosMunicipio($Id_Municipio);

       return $this->respondWithData($Municipio);
   }
   
  }
