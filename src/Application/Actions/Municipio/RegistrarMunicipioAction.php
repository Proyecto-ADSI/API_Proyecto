<?php

declare(strict_types=1);

namespace App\Application\Actions\Municipio;

use App\Domain\Municipio\Municipio;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarMunicipioAction extends MunicipioAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        // return $this->respondWithData(["ok"=> $campos]);

        $datos = new Municipio(
            0,
            $campos->Nombre,
            $campos->Id_Departamento,
            $campos->Estado,
        );
        
        $datos = $this->MunicipioRepository->RegistrarMunicipio($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

