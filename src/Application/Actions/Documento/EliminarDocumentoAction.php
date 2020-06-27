<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use Psr\Http\Message\ResponseInterface as Response;

class EliminarDocumentoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $Id_Documento = (int) $this->resolveArg("Id_Documentos");
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
        } else {
            $Validar = $this->DocumentoRepository->ValidarEliminarDocumento($Id_Documento);

            if (!empty($Validar)) {

                return $this->respondWithData(["Eliminar" => false]);
            } else {

                $Eliminar = $this->DocumentoRepository->EliminarDocumento($Id_Documento);

                return $this->respondWithData(["Eliminar" => $Eliminar]);
            }
        }
    }
}
