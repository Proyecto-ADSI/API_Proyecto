<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $Id_Documento = (int) $this->resolveArg("Id_Documentos");
        $Estado = $this->resolveArg("Estado");

        if ($Id_Documento == 0) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El ID no es valido"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (!is_numeric($Estado)) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El estado no es valido"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else {
            $datos = $this->DocumentoRepository->CambiarEstado($Id_Documento, (int) $Estado);
            return $this->respondWithData(["ok" => $datos]);
        }
    }
}
