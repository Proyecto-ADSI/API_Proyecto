<?php

declare(strict_types=1);

  namespace App\Application\Actions\Documento;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarDocumento extends DocumentoAction
  {
   protected function action(): Response
   {
       $documento = $this->DocumentoRepository->ListarDocumento();

       return $this->respondWithData($documento);
   }
   
  }
