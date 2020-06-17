<?php

declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use App\Domain\Notificacion\Notificacion;
use App\Domain\Notificaciones_Usuario\Notificaciones_Usuario;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarNotificaciones extends NotificacionesAction
{
    protected function action(): Response
    {

        return $this->respondWithData(["ok" => true]);
    }

    public function RegistrarNotificacion(Notificacion $notificacion, array $UsuariosAsignar)
    {
        $r = false;
        $r = $this->NotificacionRepository->RegistrarNotificacion($notificacion);
        $infoNotificacion = $this->NotificacionRepository->ConsultarUltimaNotificacion();
        $IdNotificacion = (int) $infoNotificacion['Id_Notificacion'];

        // Asignar notificación a usuarios
        $Usuarios = [];

        foreach ($UsuariosAsignar as $rol) {
            $res = $this->Notificaciones_UsuarioRepository->ConsultarIdUsuarios($rol);

            $Usuarios = array_merge($Usuarios, $res);
        }

        foreach ($Usuarios as $usuario) {

            $IdUsuario = (int) $usuario["Id_Usuario"];

            if ($IdUsuario != (int) $notificacion->Id_Usuario) {
                $notificacionUsuario = new Notificaciones_Usuario(
                    NULL,
                    $IdUsuario,
                    $IdNotificacion,
                    Null
                );
                $r = $this->Notificaciones_UsuarioRepository->RegistrarNotificacion_Usuario($notificacionUsuario);
            }
        }
        return $r;
    }
}
