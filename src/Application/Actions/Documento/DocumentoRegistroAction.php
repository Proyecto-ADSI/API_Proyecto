<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Domain\Documento\Documento;
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
            # code...
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "El nombre está vacío"
            ]);
        }
        else if(!is_string($Nombre)){
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "No es una cadena"
            ]);
        }
        else if (strlen($Nombre)>45) {
            # code...
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "Superó el límite de carácteres"
            ]);
        }
        else if (strlen($Estado2)>11){
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "Superó el límite de carácteres numéricos"
            ]);
        }
        else if (is_null($Estado)){
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "El campo está nulo"
            ]);
        }
        else if(!is_numeric($Estado)){
            return $this->respondWithData([
                "status code:" => 500,
                "type error:" => "Server_error",
                "Description" => "No es un numéro"
            ]);
        }
        else if(strlen($Nombre)>=1  && strlen($Nombre)<=45 && strlen($Estado2)>=1 && strlen($Estado2) <=11 )

        $datos = new Documento(
            0,
            $Nombre,
            $Estado
        );

        $datos = $this->DocumentoRepository->RegistrarDocumento($datos);

        return $this->respondWithData(["ok" => $datos]);
    }
}
