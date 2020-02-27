<?php

declare(strict_types=1);

  namespace App\Application\Actions\BarriosVeredas;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarBarriosVeredasAction extends BarriosVeredasAction
  {
   protected function action(): Response
   {
       $BarriosVeredas = $this->BarriosVeredasRepository->ListarBarriosVeredas();

       return $this->respondWithData($BarriosVeredas);
   }
   
  }
