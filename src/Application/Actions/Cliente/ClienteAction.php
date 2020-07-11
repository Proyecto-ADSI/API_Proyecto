<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Application\Actions\Action;
use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Departamento\DepartamentoRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use App\Domain\Linea\LineaRepository;
use App\Domain\Lineas_Fijas\Lineas_FijasRepository;
use App\Domain\Municipio\MunicipioRepository;
use App\Domain\Pais\PaisRepository;
use App\Domain\SubTipo\SubTipoRepository;
use App\Domain\Notificacion\NotificacionRepository;
use App\Domain\Notificaciones_Usuario\Notificaciones_UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class ClienteAction extends Action
{

    protected $ClienteRepository;
    protected $DBLRepository;
    protected $Plan_CorporativoRepository;
    protected $Doc_SoporteRepository;
    protected $BarriosVeredasRepository;
    protected $SubTipoRepository;
    protected $MunicipioRepository;
    protected $DepartamentoRepository;
    protected $PaisRepository;
    protected $LineaRepository;
    protected $Lineas_FijasRepository;
    protected $NotificacionRepository;
    protected $Notificaciones_UsuarioRepository;
    protected $AsignacionERepository;

    public function __construct(
        LoggerInterface $logger,
        ClienteRepository $ClienteRepository,
        DBLRepository $DBLRepository,
        Plan_CorporativoRepository $Plan_CorporativoRepository,
        Doc_SoporteRepository $Doc_SoporteRepository,
        BarriosVeredasRepository $BarriosVeredasRepository,
        SubTipoRepository $SubTipoRepository,
        MunicipioRepository $MunicipioRepository,
        DepartamentoRepository $DepartamentoRepository,
        PaisRepository $PaisRepository,
        LineaRepository $LineaRepository,
        Lineas_FijasRepository $Lineas_FijasRepository,
        NotificacionRepository $NotificacionRepository,
        Notificaciones_UsuarioRepository $Notificaciones_UsuarioRepository,
        AsignacionERepository $AsignacionERepository
    ) {
        parent::__construct($logger);
        $this->ClienteRepository = $ClienteRepository;
        $this->DBLRepository = $DBLRepository;
        $this->Plan_CorporativoRepository = $Plan_CorporativoRepository;
        $this->Doc_SoporteRepository = $Doc_SoporteRepository;
        $this->BarriosVeredasRepository = $BarriosVeredasRepository;
        $this->SubTipoRepository = $SubTipoRepository;
        $this->MunicipioRepository = $MunicipioRepository;
        $this->DepartamentoRepository = $DepartamentoRepository;
        $this->PaisRepository = $PaisRepository;
        $this->LineaRepository = $LineaRepository;
        $this->Lineas_FijasRepository = $Lineas_FijasRepository;
        $this->NotificacionRepository = $NotificacionRepository;
        $this->Notificaciones_UsuarioRepository = $Notificaciones_UsuarioRepository;
        $this->AsignacionERepository = $AsignacionERepository;
    }
}
