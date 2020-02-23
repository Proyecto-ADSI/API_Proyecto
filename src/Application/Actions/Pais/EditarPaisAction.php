<?php

declare(strict_types=1);

namespace App\Application\Actions\Pais;

use App\Domain\Pais\Pais;
use Psr\Http\Message\ResponseInterface as Response;

class EditarPaisAction extends PaisAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Pais(
            $campos->Id_Pais,
            $campos->Nombre,
            1
        );
        $datos = $this->PaisRepository->EditarPais($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

