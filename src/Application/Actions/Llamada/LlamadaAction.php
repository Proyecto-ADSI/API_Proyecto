<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Action;
use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use App\Domain\Llamada\LlamadaRepository;
use App\Domain\Llamada_Programada\Llamada_ProgramadaRepository;
use App\Domain\Cita\CitaRepository;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\Configuracion\ConfiguracionRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Departamento\DepartamentoRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use App\Domain\Linea\LineaRepository;
use App\Domain\Lineas_Fijas\Lineas_FijasRepository;
use App\Domain\Municipio\MunicipioRepository;
use App\Domain\Pais\PaisRepository;
use App\Domain\SubTipo\SubTipoRepository;
use App\Domain\Operador\OperadorRepository;
use App\Domain\Notificacion\NotificacionRepository;
use App\Domain\Notificaciones_Usuario\Notificaciones_UsuarioRepository;
use App\Domain\Oferta\OfertaRepository;
use App\Domain\Usuario\UsuarioRepository;
use Psr\Log\LoggerInterface;

abstract class LlamadaAction extends Action
{
    protected $LlamadaRepository;
    protected $ClienteRepository;
    protected $CitaRepository;
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
    protected $Llamada_ProgramadaRepository;
    protected $OperadorRepository;
    protected $NotificacionRepository;
    protected $Notificaciones_UsuarioRepository;
    protected $Atencion_TelefonicaRepository;
    protected $Oferta_Repository;
    protected $configuracionRepository;
    protected $UsuarioRepository;
    protected $AsignacionERepository;
    protected $usuarioRepository;

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
        LlamadaRepository $LlamadaRepository,
        CitaRepository $CitaRepository,
        Llamada_ProgramadaRepository $Llamada_ProgramadaRepository,
        OperadorRepository $OperadorRepository,
        NotificacionRepository $NotificacionRepository,
        Notificaciones_UsuarioRepository $Notificaciones_UsuarioRepository,
        AtencionTelefonicaRepository $Atencion_TelefonicaRepository,
        OfertaRepository $Oferta_Repository,
        ConfiguracionRepository $configuracionRepository,
        UsuarioRepository $UsuarioRepository,
        AsignacionERepository $AsignacionERepository,
        UsuarioRepository $usuarioRepository
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
        $this->LlamadaRepository = $LlamadaRepository;
        $this->CitaRepository = $CitaRepository;
        $this->Llamada_ProgramadaRepository = $Llamada_ProgramadaRepository;
        $this->OperadorRepository = $OperadorRepository;
        $this->NotificacionRepository = $NotificacionRepository;
        $this->Notificaciones_UsuarioRepository = $Notificaciones_UsuarioRepository;
        $this->Atencion_TelefonicaRepository = $Atencion_TelefonicaRepository;
        $this->Oferta_Repository = $Oferta_Repository;
        $this->configuracionRepository = $configuracionRepository;
        $this->UsuarioRepository = $UsuarioRepository;
        $this->AsignacionERepository = $AsignacionERepository;
        $this->usuarioRepository = $usuarioRepository;
    }
}
