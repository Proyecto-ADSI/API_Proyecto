<?php

declare(strict_types=1);

namespace App\Application\Actions\Configuracion;

use App\Application\Actions\Action;
use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\Configuracion\ConfiguracionRepository;
use App\Domain\Usuario\UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class ConfiguracionAction extends Action
{
    protected $ConfiguracionRepository;
    protected $UsuarioRepository;
    protected $ClienteRepository;
    protected $AsignacionERepository;

    public function __construct(
        LoggerInterface $logger,
        ConfiguracionRepository $ConfiguracionRepository,
        UsuarioRepository $UsuarioRepository,
        ClienteRepository $ClienteRepository,
        AsignacionERepository $AsignacionERepository
    ) {
        parent::__construct($logger);
        $this->ConfiguracionRepository = $ConfiguracionRepository;
        $this->UsuarioRepository = $UsuarioRepository;
        $this->ClienteRepository = $ClienteRepository;
        $this->AsignacionERepository = $AsignacionERepository;
    }
}
