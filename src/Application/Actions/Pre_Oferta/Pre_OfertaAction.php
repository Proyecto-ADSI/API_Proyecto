<?php

declare(strict_types=1);

namespace App\Application\Actions\Pre_Oferta;

use App\Application\Actions\Action;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Pre_Oferta\PreOfertaRepository;
use Psr\Log\LoggerInterface;

abstract class Pre_OfertaAction extends Action
{
    protected $Pre_OfertaRepository;
    protected $AtencionTelefonicaRepository;
    protected $DBLRepository;

    public function __construct(
        LoggerInterface $logger,
        PreOfertaRepository $Pre_OfertaRepository,
        AtencionTelefonicaRepository $AtencionTelefonicaRepository,
        DBLRepository $DBLRepository
    ) {
        parent::__construct($logger);
        $this->Pre_OfertaRepository = $Pre_OfertaRepository;
        $this->AtencionTelefonicaRepository = $AtencionTelefonicaRepository;
        $this->DBLRepository = $DBLRepository;
    }
}
