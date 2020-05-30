<?php

declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoLecturaNotificacion extends NotificacionesAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");
 
        $res = $this->Notificaciones_UsuarioRepository->CambiarEstadoLecturaNU($Id_Usuario);
        
        return $this->respondWithData(["ok"=>$res]);
        
    }
}

