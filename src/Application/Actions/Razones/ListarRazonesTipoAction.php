<?php

declare(strict_types=1);

  namespace App\Application\Actions\Razones;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarRazonesTipoAction extends RazonesAction
  {
   protected function action(): Response
   {
      $Tipo = $this->resolveArg("Tipo");
      $Razones = $this->RazonesRepository->ListarRazonesTipo($Tipo);

      return $this->respondWithData($Razones);
   }
   
  }