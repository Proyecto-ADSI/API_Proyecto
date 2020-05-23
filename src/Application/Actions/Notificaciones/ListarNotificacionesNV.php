<?php

declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class ListarNotificacionesNV extends NotificacionesAction
{

    protected function action(): Response
    {   
        
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");
        
        $Notificaciones = $this->Notificaciones_UsuarioRepository->ListarNotificacionesNoVisitadas($Id_Usuario);

        return $this->respondWithData($Notificaciones);
    }
}
