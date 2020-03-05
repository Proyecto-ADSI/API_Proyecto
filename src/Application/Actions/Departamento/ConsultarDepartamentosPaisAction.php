<?php

declare(strict_types=1);

  namespace App\Application\Actions\Departamento;

  use Psr\Http\Message\ResponseInterface as Response;

  class ConsultarDepartamentosPaisAction extends DepartamentoAction
  {
   protected function action(): Response
   {
        $Id_Pais = (int) $this->resolveArg("Id_Pais");

        $Departamentos = $this->DepartamentoRepository->ConsultarDepartamentosPais($Id_Pais);

        return $this->respondWithData($Departamentos);
   }
   
  }