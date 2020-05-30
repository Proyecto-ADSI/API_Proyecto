<?php
declare(strict_types=1);

namespace App\Domain\Notificacion;

interface NotificacionRepository{

    public function RegistrarNotificacion(Notificacion $Notificacion);

    public function ConsultarUltimaNotificacion();
}