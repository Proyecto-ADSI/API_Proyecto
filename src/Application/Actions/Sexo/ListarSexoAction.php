<?php

declare(strict_types=1);

  namespace App\Application\Actions\Sexo;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarSexoAction extends SexoAction
  {
   protected function action(): Response
   {
       $Sexo = $this->SexoRepository->ListarSexo();

       return $this->respondWithData($Sexo);
   }
   
  }
