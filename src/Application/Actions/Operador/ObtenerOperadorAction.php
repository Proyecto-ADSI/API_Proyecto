<?php

declare(strict_types=1);

  namespace App\Application\Actions\Operador;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerOperadorAction extends OperadorAction
  {
   protected function action(): Response
   {

       $Id_Operador= $this->resolveArg("Id_Operador");

       $Operador = $this->OperadorRepository->ObtenerDatosOperador($Id_Operador);

       return $this->respondWithData($Operador);
   }
   
  }
