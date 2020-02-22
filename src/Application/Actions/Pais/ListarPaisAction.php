<?php

declare(strict_types=1);

  namespace App\Application\Actions\Pais;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarPaisAction extends PaisAction
  {
   protected function action(): Response
   {
       $Pais = $this->PaisRepository->ListarPais();

       return $this->respondWithData($Pais);
   }
   
  }
