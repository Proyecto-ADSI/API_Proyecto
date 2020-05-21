<?php
declare(strict_types=1);

namespace App\Domain\Notificaciones_Usuario;

interface Notificaciones_UsuarioRepository{

    public function RegistrarNotificacion_Usuario(Notificaciones_Usuario $Notificaciones_Usuario);

    public function ListarNotificaciones_Usuario(int $Id_Usuario);

    public function ListarNotificacionesNoLeidas(int $Id_Usuario);
    
    public function CambiarEstadoNU(int $Id_Usuario, int $EstadoNU);

    public function EliminarNotificacion_Usuario(int $Id_NU);

    public function ConsultarIdUsuarios(int $Id_Rol);
    
}