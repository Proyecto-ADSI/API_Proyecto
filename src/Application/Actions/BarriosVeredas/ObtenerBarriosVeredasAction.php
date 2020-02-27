<?php

declare(strict_types=1);

  namespace App\Application\Actions\BarriosVeredas;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerBarriosVeredasAction extends BarriosVeredasAction
  {
   protected function action(): Response
   {

       $Id_Barrios_Veredas= $this->resolveArg("Id_Barrios_Veredas");

       $BarriosVeredas = $this->BarriosVeredasRepository->ObtenerDatosBarriosVeredas(intval($Id_Barrios_Veredas));

       return $this->respondWithData($BarriosVeredas);
   }
   
  }
