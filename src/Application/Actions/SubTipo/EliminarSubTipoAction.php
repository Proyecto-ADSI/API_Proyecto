<?php

declare(strict_types=1);

namespace App\Application\Actions\SubTipo;

use App\Application\Actions\SubTipo\SubTipoAction;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarSubTipoAction extends SubTipoAction
{
    protected function action(): Response
    {
        $Id_SubTipo_Barrio_Vereda = (int)$this->resolveArg("Id_SubTipo_Barrio_Vereda");
        $Validar = $this->SubTipoRepository->ValidarSubTipoEliminar($Id_SubTipo_Barrio_Vereda);

       

        // return $this->respondWithData(["Eliminar" => $Validar]);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);

        }else{

            $Eliminar = $this->SubTipoRepository->EliminarSubTipo($Id_SubTipo_Barrio_Vereda);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
    }
}

