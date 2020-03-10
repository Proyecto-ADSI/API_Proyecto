<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Domain\Documento\Documento;
use Psr\Http\Message\ResponseInterface as Response;

class EditarDocumentoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $datos = new Documento(
            $campos->Id_Documento,
            $campos->Nombre,
            null,
        );
        $datos = $this->DocumentoRepository->EditarDocumento($datos);

        return $this->respondWithData(["ok" =>$datos]);
        
    }
}

