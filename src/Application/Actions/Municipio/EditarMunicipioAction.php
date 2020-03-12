<?php

declare(strict_types=1);

namespace App\Application\Actions\Municipio;

use App\Domain\Municipio\Municipio;
use Psr\Http\Message\ResponseInterface as Response;

class EditarMunicipioAction extends MunicipioAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Municipio(
            $campos->Id_Municipios,
            $campos->Nombre,
            $campos->Id_Departamento,
            null,
        );
        $datos = $this->MunicipioRepository->EditarMunicipio($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

