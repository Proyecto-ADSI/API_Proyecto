<?php

declare(strict_types=1);

namespace App\Application\Actions\Municipio;


use Psr\Http\Message\ResponseInterface as Response;

class EliminarMunicipioAction extends MunicipioAction
{
    protected function action(): Response
    {
        $Id_Municipio = (int)$this->resolveArg("Id_Municipio");

        $Validar = $this->MunicipioRepository->ValidarEliminarMunicipio($Id_Municipio);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $Eliminar = $this->MunicipioRepository->EliminarMunicipio($Id_Municipio);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

