<?php
declare(strict_types=1);

namespace App\Application\Actions\Visitas;

use App\Application\Actions\Action;
use App\Domain\Visitas\VisitasRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Linea\LineaRepository;
use App\Domain\Oferta\OfertaRepository;
use Psr\Log\LoggerInterface;

abstract class VisitasAction extends Action
{
   
    protected $VisitasRepository;
    protected $DBLRepository;
    protected $PlanCorporativoRepository;
    protected $LineaRepository;
    protected $OfertaRepository;
   
    public function __construct(LoggerInterface $logger, VisitasRepository $VisitasRepository, DBLRepository $DBLRepository, Plan_CorporativoRepository $PlanCorporativoRepository, LineaRepository $LineaRepository, OfertaRepository $OfertaRepository)
    {
        parent::__construct($logger);
        $this->VisitasRepository = $VisitasRepository;
        $this->DBLRepository = $DBLRepository;
        $this->PlanCorporativoRepository = $PlanCorporativoRepository;
        $this->LineaRepository = $LineaRepository;
        $this->OfertaRepository = $OfertaRepository;
    }
}