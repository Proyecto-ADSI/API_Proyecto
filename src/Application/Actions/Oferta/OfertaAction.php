<?php

declare(strict_types=1);

namespace App\Application\Actions\Oferta;

use App\Application\Actions\Action;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Oferta\OfertaRepository;
use Psr\Log\LoggerInterface;

abstract class OfertaAction extends Action
{
    protected $OfertaRepository;
    protected $AtencionTelefonicaRepository;
    protected $DBLRepository;

    public function __construct(
        LoggerInterface $logger,
        OfertaRepository $OfertaRepository,
        AtencionTelefonicaRepository $AtencionTelefonicaRepository,
        DBLRepository $DBLRepository
    ) {
        parent::__construct($logger);
        $this->OfertaRepository = $OfertaRepository;
        $this->AtencionTelefonicaRepository = $AtencionTelefonicaRepository;
        $this->DBLRepository = $DBLRepository;
    }
}
