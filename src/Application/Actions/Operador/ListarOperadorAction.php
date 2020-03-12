<?php

declare(strict_types=1);

  namespace App\Application\Actions\Operador;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarOperadorAction extends OperadorAction
  {
   protected function action(): Response
   {
       $Operador = $this->OperadorRepository->ListarOPerador();

       return $this->respondWithData($Operador);
   }
   
  }
