<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerEmpresasAsignadas extends ClienteAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");
        $idEmpresas = $this->AsignacionERepository->ListarEmpresasContact($Id_Usuario);
        $infoEmpresas = [];
        foreach ($idEmpresas as $idEmpresa) {
            $Id_Cliente = (int) $idEmpresa['Id_Cliente'];
            $infoEmpresa = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
            array_push($infoEmpresas, $infoEmpresa);
        }
        return $this->respondWithData($infoEmpresas);
    }
}
