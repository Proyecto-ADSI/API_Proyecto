<?php
declare(strict_types=1);

namespace App\Application\Actions\Calificacion;

use App\Application\Actions\Action;
use App\Domain\Calificacion\CalificacionRepository;
use Psr\Log\LoggerInterface;

abstract class CalificacionAction extends Action
{
    /**
     * @var CalificacionRepository
     */
    protected $CalificacionRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param CalificacionRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, CalificacionRepository $CalificacionRepository)
    {
        parent::__construct($logger);
        $this->CalificacionRepository = $CalificacionRepository;
    }
}
