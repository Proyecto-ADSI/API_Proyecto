<?php

declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class ListarNotificacionesNL extends NotificacionesAction
{

    protected function action(): Response
    {   
        
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");
        
        $Notificaciones = $this->Notificaciones_UsuarioRepository->ListarNotificacionesNoLeidas($Id_Usuario);

        return $this->respondWithData($Notificaciones);
    }
}
