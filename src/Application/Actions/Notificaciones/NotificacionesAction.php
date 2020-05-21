<?php
declare(strict_types=1);

namespace App\Application\Actions\Notificaciones;

use App\Application\Actions\Action;
use App\Domain\Notificaciones_Usuario\Notificaciones_UsuarioRepository;
use App\Domain\Notificacion\NotificacionRepository;
// use App\Domain\Usuario\UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class NotificacionesAction extends Action
{
    /**
     * @var Notificaciones_UsuarioRepository
     */
    protected $Notificaciones_UsuarioRepository;
    protected $NotificacionRepository;
    // protected $UsuarioRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param Notificaciones_UsuarioRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, 
    Notificaciones_UsuarioRepository $Notificaciones_UsuarioRepository,
    NotificacionRepository $NotificacionRepository
    // UsuarioRepository $UsuarioRepository
    )
    {
        parent::__construct($logger);
        $this->Notificaciones_UsuarioRepository = $Notificaciones_UsuarioRepository;
        $this->NotificacionRepository = $NotificacionRepository;
        // $this->UsuarioRepository = $UsuarioRepository;
    }
}
