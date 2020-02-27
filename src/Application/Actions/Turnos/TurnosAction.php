<?php
declare(strict_types=1);

namespace App\Application\Actions\Turnos;

use App\Application\Actions\Action;
use App\Domain\Turnos\TurnosRepository;
use Psr\Log\LoggerInterface;

abstract class TurnosAction extends Action
{
    /**
     * @var TurnosRepository
     */
    protected $TurnosRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param TurnosRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, TurnosRepository $TurnosRepository)
    {
        parent::__construct($logger);
        $this->TurnosRepository = $TurnosRepository;
    }
}
