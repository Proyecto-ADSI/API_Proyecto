<?php
declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use App\Application\Actions\Action;
use App\Domain\Empleado\EmpleadoRepository;
use App\Domain\Usuario\UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class UsuarioAction extends Action
{
    /**
     * @var UsuarioRepository
     * @var EmpleadoRepository
     */
    protected $usuarioRepository;
    protected $EmpleadoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param UsuarioRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, UsuarioRepository $usuarioRepository, EmpleadoRepository $EmpleadoRepository)
    {
        parent::__construct($logger);
        $this->usuarioRepository = $usuarioRepository;
        $this->EmpleadoRepository = $EmpleadoRepository;
    }
}
