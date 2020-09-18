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

    public function RegistrarNotificacion(Notificacion $notificacion, array $rolesAsignar)
    {

        // Registro notificación
        $r = false;
        $r = $this->NotificacionRepository->RegistrarNotificacion($notificacion);
        $infoNotificacion = $this->NotificacionRepository->ConsultarUltimaNotificacion();
        $IdNotificacion = (int) $infoNotificacion['Id_Notificacion'];

        // Asignar notificación a estos usuarios
        $Usuarios = [];

        // Consultar usuarios según los roles que se deban notificar.
        foreach ($rolesAsignar as $rol) {
            $res = $this->Notificaciones_UsuarioRepository->ConsultarIdUsuarios($rol);

            $Usuarios = array_merge($Usuarios, $res);
        }

        foreach ($Usuarios as $usuario) {

            $IdUsuario = (int) $usuario["Id_Usuario"];
            // Se valida que solo se registre la notificación a un usuario diferente a quien la origina o registra.
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
