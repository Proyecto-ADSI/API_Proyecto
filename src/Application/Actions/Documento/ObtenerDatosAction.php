<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerDatosAction extends DocumentoAction
{
  protected function action(): Response
  {

    $Id_Documentos = (int) $this->resolveArg("Id_Documentos");

    if ($Id_Documentos == 0) {
      $data = [
        "statusCode:" => 404,
        "type error:" => "NOT FOUND",
        "Description" => "Registro no encontrado "
      ];

      $payload = json_encode($data);
      $this->response->getBody()->write($payload);
      return $this->response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
    } else {
      $documento = $this->DocumentoRepository->ObtenerDatos($Id_Documentos);

      return $this->respondWithData($documento);
    }
  }
}
