<?php

declare(strict_types=1);

  namespace App\Application\Actions\BarriosVeredas;

  use Psr\Http\Message\ResponseInterface as Response;

  class ConsultarBarriosVeredasMunicipioAction extends BarriosVeredasAction
  {
   protected function action(): Response
   {
        $Id_Municipio = (int) $this->resolveArg("Id_Municipio");

        $Id_SubTipo = (int) $this->resolveArg("Id_SubTipo");

        $Barrios_Veredas = $this->BarriosVeredasRepository->ConsultarBarriosVeredasMunicipio($Id_Municipio,$Id_SubTipo);

        return $this->respondWithData($Barrios_Veredas);
   }
   
  }