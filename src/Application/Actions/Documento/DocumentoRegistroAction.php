<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Domain\Documento\Documento;
use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;

use Psr\Http\Message\ResponseInterface as Response;


class DocumentoRegistroAction extends DocumentoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $Estado1 = $campos->Estado;

        $Estado2 = strval($Estado1);

        $Nombre = $campos->Nombre;
        $Estado = $campos->Estado;

        if (empty($Nombre)) {
            $data = [
                "statusCode:" => 400,
<<<<<<< HEAD
                "type error:" => "Bad_Request",
=======
                "type error:" => "BAD_REQUEST",
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
                "Description" => "El nombre esta vacio"
            ];

            $payload = json_encode($data, JSON_PRETTY_PRINT);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (!is_string($Nombre)) {
            $data = [
                "statusCode:" => 400,
<<<<<<< HEAD
                "type error:" => "Bad_Request",
=======
                "type error:" => "BAD_REQUEST",
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
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
<<<<<<< HEAD
                "type error:" => "Bad_Request",
                "Description" => "Supero el limite de carácteres"
=======
                "type error:" => "BAD_REQUEST",
                "Description" => "Supero el limite de caracteres"
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (strlen($Estado2) > 11) {
            $data = [
                "statusCode:" => 400,
<<<<<<< HEAD
                "type error:" => "Bad_Request",
                "Description" => "Supero el limite de carácteres numericos"
=======
                "type error:" => "BAD_REQUEST",
                "Description" => "Supero el limite de caracteres numericos"
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (is_null($Estado)) {

            $data = [
                "statusCode:" => 400,
<<<<<<< HEAD
                "type error:" => "Bad_Request",
=======
                "type error:" => "BAD_REQUEST",
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
                "Description" => "El campo esta nulo"
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (!is_int($Estado)) {
            $data = [
                "statusCode:" => 400,
<<<<<<< HEAD
                "type error:" => "Bad_Request",
=======
                "type error:" => "BAD_REQUEST",
>>>>>>> 9c546e2d79967c07044abc9891d5bac11cdd0b83
                "Description" => "No es un numero"
            ];

            $payload = json_encode($data);
            $this->response->getBody()->write($payload);
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } else if (strlen($Nombre) >= 1  && strlen($Nombre) <= 45 && strlen($Estado2) >= 1 && strlen($Estado2) <= 11) {

            $datos = new Documento(
                0,
                $Nombre,
                $Estado
            );
            $datos = $this->DocumentoRepository->RegistrarDocumento($datos);
            $Id_Registro = $this->DocumentoRepository->ConsultarUltimoRegistrado();
            $Id_Registro = (int) $Id_Registro['Id_Documento'];
            return $this->respondWithData(["ok" => $datos, "Id_Registro" => $Id_Registro]);
        }
    }
}
