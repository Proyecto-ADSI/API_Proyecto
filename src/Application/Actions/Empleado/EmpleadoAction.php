<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use App\Application\Actions\Action;
use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\Configuracion\ConfiguracionRepository;
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
    protected $configuracionRepository;
    protected $ClienteRepository;
    protected $AsignacionERepository;


    /**
     * @param LoggerInterface $logger
     * @param EmpleadoRepository  $userRepository
     */
    public function __construct(
        LoggerInterface $logger,
        EmpleadoRepository $EmpleadoRepository,
        UsuarioRepository $UsuarioRepository,
        ConfiguracionRepository $configuracionRepository,
        ClienteRepository $ClienteRepository,
        AsignacionERepository $AsignacionERepository
    ) {
        parent::__construct($logger);
        $this->EmpleadoRepository = $EmpleadoRepository;
        $this->UsuarioRepository = $UsuarioRepository;
        $this->configuracionRepository = $configuracionRepository;
        $this->ClienteRepository = $ClienteRepository;
        $this->AsignacionERepository = $AsignacionERepository;
    }
}
