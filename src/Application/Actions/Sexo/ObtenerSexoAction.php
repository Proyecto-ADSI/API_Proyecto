<?php

declare(strict_types=1);

  namespace App\Application\Actions\Sexo;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerSexoAction extends SexoAction
  {
   protected function action(): Response
   {

       $Id_Sexo= $this->resolveArg("Id_Sexo");

       $Sexo = $this->SexoRepository->ObtenerDatos($Id_Sexo);

       return $this->respondWithData($Sexo);
   }
   
  }
