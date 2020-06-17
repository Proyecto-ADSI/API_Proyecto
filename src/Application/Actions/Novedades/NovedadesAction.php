<?php
declare(strict_types=1);

namespace App\Application\Actions\Novedades;

use App\Application\Actions\Action;
use App\Domain\Novedades\NovedadesRepository;
use Psr\Log\LoggerInterface;

abstract class NovedadesAction extends Action
{
    /**
     * @var NovedadesRepository
     */
    protected $NovedadesRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param NovedadesRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, NovedadesRepository $NovedadesRepository)
    {
        parent::__construct($logger);
        $this->NovedadesRepository = $NovedadesRepository;
    }
}
