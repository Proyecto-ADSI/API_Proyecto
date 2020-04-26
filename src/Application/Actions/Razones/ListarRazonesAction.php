<?php

declare(strict_types=1);

  namespace App\Application\Actions\Razones;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarRazonesAction extends RazonesAction
  {
   protected function action(): Response
   {
       $Razones = $this->RazonesRepository->ListarRazones();

       return $this->respondWithData($Razones);
   }
   
  }
