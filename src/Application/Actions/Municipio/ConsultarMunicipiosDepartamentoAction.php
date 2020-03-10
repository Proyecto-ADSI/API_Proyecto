<?php

declare(strict_types=1);

  namespace App\Application\Actions\Municipio;

  use Psr\Http\Message\ResponseInterface as Response;

  class ConsultarMunicipiosDepartamentoAction extends MunicipioAction
  {
   protected function action(): Response
   {
        $Id_Departamento = (int) $this->resolveArg("Id_Departamento");

        $Municipios = $this->MunicipioRepository->ConsultarMunicipiosDepartamento($Id_Departamento);

        return $this->respondWithData($Municipios);
   }
   
  }