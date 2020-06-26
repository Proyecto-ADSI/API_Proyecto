<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Domain\Operador\Operador;
use Psr\Http\Message\ResponseInterface as Response;

class EditarOperadorAction extends OperadorAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();
        $Id_Operador = (int) $campos->Id_Operador;
        $dataActual = $this->OperadorRepository->ObtenerDatosOperador($Id_Operador);

        $Correo_Operador = $dataActual['Correo_Operador'];
        $Contrasena_Operador = $dataActual['Contrasena_Operador'];

        if ($campos->Genera_Oferta == 1) {
            $Correo_Operador = $campos->Correo_Operador;
            if ($campos->Editar_Contrasena) {
                $Contrasena_Operador = $campos->Contrasena_Operador;
            }
        }
        $Imagen_Operador = $dataActual['Imagen_Operador'];
        if ($campos->Editar_Img) {
            $Imagen_Operador = $campos->Imagen_Operador;
        }

        $dataNueva = new Operador(
            $Id_Operador,
            $campos->Nombre,
            $campos->Color,
            $campos->Genera_Oferta,
            $Correo_Operador,
            $Contrasena_Operador,
            $Imagen_Operador,
            null,
        );

        $res = $this->OperadorRepository->EditarOperador($dataNueva);

        return $this->respondWithData(["ok" => $res]);
    }
}
