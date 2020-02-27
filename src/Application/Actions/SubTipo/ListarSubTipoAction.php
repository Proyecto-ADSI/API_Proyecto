<?php

declare(strict_types=1);

  namespace App\Application\Actions\SubTipo;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarSubTipoAction extends SubTipoAction
  {
   protected function action(): Response
   {
       $SubTipo = $this->SubTipoRepository->ListarSubTipo();

       return $this->respondWithData($SubTipo);
   }
   
  }
