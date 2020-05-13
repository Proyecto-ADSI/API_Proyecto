<?php

declare(strict_types=1);

namespace App\Application\Actions\Sexo;

use App\Application\Actions\Sexo\SexoAction;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarSexoAction extends SexoAction
{
    protected function action(): Response
    {
        $Id_Sexos = (int)$this->resolveArg("Id_Sexo");

        $Validar = $this->SexoRepository->ValidarEliminarSexo($Id_Sexos);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
            
        }else{

           $Eliminar = $this->SexoRepository->EliminarSexo($Id_Sexos);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

