<?php
declare(strict_types=1);

namespace App\Application\Actions\BarriosVeredas;

use App\Application\Actions\Action;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use Psr\Log\LoggerInterface;

abstract class BarriosVeredasAction extends Action
{
    /**
     * @var BarriosVeredasRepository
     */
    protected $BarriosVeredasRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param BarriosVeredasRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, BarriosVeredasRepository $BarriosVeredasRepository)
    {
        parent::__construct($logger);
        $this->BarriosVeredasRepository = $BarriosVeredasRepository;
    }
}
