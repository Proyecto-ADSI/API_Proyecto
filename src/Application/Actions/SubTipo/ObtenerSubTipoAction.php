<?php

declare(strict_types=1);

  namespace App\Application\Actions\SubTipo;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerSubTipoAction extends SubTipoAction
  {
   protected function action(): Response
   {

       $Id_SubTipo_Barrio_Vereda = $this->resolveArg("Id_SubTipo_Barrio_Vereda");

       $SubTipo = $this->SubTipoRepository->ObtenerDatosSubTipo(intval($Id_SubTipo_Barrio_Vereda));

       return $this->respondWithData($SubTipo);
   }
   
  }
