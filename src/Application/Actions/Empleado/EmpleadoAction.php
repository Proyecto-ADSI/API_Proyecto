<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use App\Application\Actions\Action;
use App\Domain\Empleado\EmpleadoRepository;
use App\Domain\Usuario\UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class EmpleadoAction extends Action
{
    /**
     * @var EmpleadoRepository
     */
    protected $EmpleadoRepository;
    protected $UsuarioRepository;


    /**
     * @param LoggerInterface $logger
     * @param EmpleadoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, EmpleadoRepository $EmpleadoRepository, UsuarioRepository $UsuarioRepository)
    {
        parent::__construct($logger);
        $this->EmpleadoRepository = $EmpleadoRepository;
        $this->UsuarioRepository = $UsuarioRepository;
    }
}
