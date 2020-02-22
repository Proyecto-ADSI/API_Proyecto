<?php

declare(strict_types=1);

  namespace App\Application\Actions\Documento;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosAction extends DocumentoAction
  {
   protected function action(): Response
   {

       $Id_Documentos= $this->resolveArg("Id_Documentos");

       $documento = $this->DocumentoRepository->ObtenerDatos($Id_Documentos);

       return $this->respondWithData($documento);
   }
   
  }
