<?php

declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Domain\Documento\Documento;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarDocumentoAction extends DocumentoAction
{
    protected function action(): Response
    {
        $Id_Documentos = (int)$this->resolveArg("Id_Documentos");

        $Validar = $this->DocumentoRepository->ValidarEliminarDocumento($Id_Documentos);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $Eliminar = $this->DocumentoRepository->EliminarDocumento($Id_Documentos);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

