<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Domain\Documento\Documento;
use Psr\Http\Message\ResponseInterface as Response;

class EditarDocumentoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $Id_Documento2 = strval($campos->Id_Documento);

        $Nombre = $campos->Nombre;
        $Id_Documento = $campos->Id_Documento;

        if (is_null($Id_Documento)) {

            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El ID esta nulo"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (!is_int($Id_Documento)) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El ID no es un numero"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (strlen($Id_Documento2) > 11) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El ID Superó el límite de caracteres numéricos"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if ($Id_Documento == 0) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El ID no puede ser 0 (Cero)"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (empty($Nombre)) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "El nombre esta vacio"
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (!is_string($Nombre)) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "No es una cadena"
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (strlen($Nombre) > 45) {
            $data = [
                "statusCode:" => 400,
                "type error:" => "BAD_REQUEST",
                "Description" => "Supero el limite de caracteres"
            ];
            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (strlen($Nombre) >= 1  && strlen($Nombre) <= 45 && strlen($Id_Documento2) >= 1 && strlen($Id_Documento2) <= 11) {
            $datos = new Documento(
                $campos->Id_Documento,
                $campos->Nombre,
                null,
            );
            $datos = $this->DocumentoRepository->EditarDocumento($datos);
            return $this->respondWithData(["ok" => $datos]);
        }
    }
}
