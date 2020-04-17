<?php

declare(strict_types=1);

namespace App\Application\Actions\Pais;

use App\Application\Actions\Pais\PaisAction;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarPaisAction extends PaisAction
{
    protected function action(): Response
    {
        $Id_Paiss = (int)$this->resolveArg("Id_Pais");

        $Validar = $this->PaisRepository->ValidarPaisEliminar($Id_Paiss);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $Eliminar = $this->PaisRepository->EliminarPais($Id_Paiss);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

