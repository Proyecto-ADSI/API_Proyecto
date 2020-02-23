<?php

declare(strict_types=1);

  namespace App\Application\Actions\Departamento;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosDepartamentoAction extends DepartamentoAction
  {
   protected function action(): Response
   {

       $Id_Departamento= $this->resolveArg("Id_Departamento");

       $Departamento = $this->DepartamentoRepository->ObtenerDatosDepartamento($Id_Departamento);

       return $this->respondWithData($Departamento);
   }
   
  }
