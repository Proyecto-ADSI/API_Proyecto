<?php

declare(strict_types=1);

  namespace App\Application\Actions\Municipio;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarMunicipioAction extends MunicipioAction
  {
   protected function action(): Response
   {
       $Municipio = $this->MunicipioRepository->ListarMunicipio();

       return $this->respondWithData($Municipio);
   }
   
  }
