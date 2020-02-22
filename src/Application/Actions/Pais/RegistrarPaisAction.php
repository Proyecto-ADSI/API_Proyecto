<?php

declare(strict_types=1);

namespace App\Application\Actions\Pais;

use App\Domain\Pais\Pais;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarPaisAction extends PaisAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Pais(
            0,
            $campos->Nombre,
            $campos->Estado
        );
        
        $datos = $this->PaisRepository->RegistrarPais($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

