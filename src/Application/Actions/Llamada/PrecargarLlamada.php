<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Configuracion\MetodosSistema;
use Psr\Http\Message\ResponseInterface as Response;

class PrecargarLlamada extends LlamadaAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");

        // Validar si el usuario tiene empresas asignadas, sino tiene asignarle.
        $infoVal =  $this->AsignacionERepository->ValidarEmpresasAsignadas($Id_Usuario);
        $valEmpresasContact = (int) $infoVal['Cantidad'];

        $metodos = new MetodosSistema(
            $this->logger,
            $this->configuracionRepository,
            $this->UsuarioRepository,
            $this->ClienteRepository,
            $this->AsignacionERepository,
        );

        if ($valEmpresasContact == 0) {
            // Asignar empresas
            $res = $metodos->AsignarEmpresas($Id_Usuario);
            if ($res['ok'] != true) {
                return $this->respondWithData($res);
            }
        }

        // Retornar datos de un cliente
        $infoEmpresa = $metodos->PrecargarEmpresa($Id_Usuario);

        return $this->respondWithData(["ok" => true, "info" => $infoEmpresa]);
    }
}
