<?php
declare(strict_types=1);

namespace App\Application\Actions\Visitas;

use App\Application\Actions\Action;
use App\Domain\Visitas\VisitasRepository;
use Psr\Log\LoggerInterface;

abstract class VisitasAction extends Action
{
    /**
     * @var DocumentoRepository
     */
    protected $VisitasRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param DocumentoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, VisitasRepository $VisitasRepository)
    {
        parent::__construct($logger);
        $this->VisitasRepository = $VisitasRepository;
    }
}