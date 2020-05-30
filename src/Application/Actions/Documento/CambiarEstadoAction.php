<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $Id_Documentos = $this->resolveArg("Id_Documentos");
        $Estado = $this->resolveArg("Estado");

        $datos = $this->DocumentoRepository->CambiarEstado(intval($Id_Documentos), intval($Estado));


        return $this->respondWithData(["ok"=>$datos]);
        
    }
}

