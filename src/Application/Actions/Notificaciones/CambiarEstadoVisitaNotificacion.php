<?php
declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoVisitaNotificacion extends NotificacionesAction
{
    protected function action(): Response
    {
        $Id_NU = (int) $this->resolveArg("Id_NU");
 
        $res = $this->Notificaciones_UsuarioRepository->CambiarEstadoVisitaNU($Id_NU);
        
        return $this->respondWithData(["ok"=>$res]);
        
    }
}

