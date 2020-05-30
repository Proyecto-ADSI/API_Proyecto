<?php

declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class EliminarNotificaciones extends NotificacionesAction
{
    protected function action(): Response
    {
        $Id_Notificacion = (int)$this->resolveArg("Id_Notificacion");

        $Eliminar = $this->Notificaciones_UsuarioRepository->EliminarNotificacion_Usuario($Id_Notificacion);

        return $this->respondWithData(["Eliminar" => $Eliminar]);

    }
}

