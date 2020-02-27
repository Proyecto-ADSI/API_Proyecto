<?php

declare(strict_types=1);

namespace App\Application\Actions\SubTipo;

use App\Domain\SubTipo\SubTipo;
use Psr\Http\Message\ResponseInterface as Response;

class EditarSubTipoAction extends SubTipoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();
        
        $datos = new SubTipo(

            $campos->Id_SubTipo_Barrio_Vereda,
            $campos->SubTipo,
            $campos->Estado,
            
        );
        
        $datos = $this->SubTipoRepository->EditarSubTipo($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

