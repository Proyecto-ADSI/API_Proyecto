<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Application\Actions\Operador\OperadorAction;
use App\Domain\Operador\Operador;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Operador(
            NULL,
            $campos->Nombre,
            $campos->Color,
            $campos->Genera_Oferta,
            $campos->Correo_Operador,
            $campos->Contrasena_Operador,
            $campos->Imagen_Operador,
            $campos->Estado,
        );

        $datos = $this->OperadorRepository->RegistrarOperador($datos);

        return $this->respondWithData(["ok" => $datos]);
    }
}
