<?php
declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Action;
use App\Domain\Llamada\LlamadaRepository;
use App\Domain\Llamada_Programada\Llamada_ProgramadaRepository;
use App\Domain\Cita\CitaRepository;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Departamento\DepartamentoRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use App\Domain\Linea\LineaRepository;
use App\Domain\Municipio\MunicipioRepository;
use App\Domain\Pais\PaisRepository;
use App\Domain\SubTipo\SubTipoRepository;
use App\Domain\Operador\OperadorRepository;
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
    protected $Llamada_ProgramadaRepository;
    protected $OperadorRepository;

    


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
        LlamadaRepository $LlamadaRepository,
        CitaRepository $CitaRepository,
        Llamada_ProgramadaRepository $Llamada_ProgramadaRepository,
        OperadorRepository $OperadorRepository
    )
    {
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
        $this->LlamadaRepository = $LlamadaRepository;
        $this->CitaRepository = $CitaRepository;
        $this->Llamada_ProgramadaRepository = $Llamada_ProgramadaRepository;
        $this->OperadorRepository = $OperadorRepository;
    }
}
