<?php

declare(strict_types=1);

  namespace App\Application\Actions\Departamento;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarDepartamentoAction extends DepartamentoAction
  {
   protected function action(): Response
   {
       $Departamento = $this->DepartamentoRepository->ListarDepartamento();

       return $this->respondWithData($Departamento);
   }
   
  }
