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

        $datos = new Documento(
            0,
            $campos->Nombre,
            $campos->Estado
        );
        
        $datos = $this->DocumentoRepository->RegistrarDocumento($datos);
        
        return $this->respondWithData(["ok"=> $datos]);
        
    }
}

