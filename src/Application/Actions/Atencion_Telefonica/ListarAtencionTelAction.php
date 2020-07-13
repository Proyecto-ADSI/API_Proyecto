<?php

declare(strict_types=1);

namespace App\Application\Actions\Atencion_Telefonica;

use Psr\Http\Message\ResponseInterface as Response;

class ListarAtencionTelAction extends AtencionTelAction
{
    protected function action(): Response
    {
        $res = $this->AtencionTelefonicaRepository->ListarAtencionTelefonica();

        return $this->respondWithData($res);
    }
}
