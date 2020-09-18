<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use App\Application\Actions\Visitas\VisitasAction;
use Psr\Http\Message\ResponseInterface as Response;


class EliminarPdfAction extends VisitasAction {

    protected function action(): Response
    {

        $Campos = $this->getFormData();

        $RutaPlubic = $_SERVER['DOCUMENT_ROOT'];

        $Eliminado = unlink($RutaPlubic.'\Reportes' . DIRECTORY_SEPARATOR . $Campos->NombrePDF);
        
        return $this->respondWithData(["Ok"=>$Eliminado]);
    }
}