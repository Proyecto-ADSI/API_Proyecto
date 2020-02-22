<?php
declare(strict_types=1);

namespace App\Application\Actions\Pais;

use App\Application\Actions\Action;
use App\Domain\Pais\PaisRepository;
use Psr\Log\LoggerInterface;

abstract class PaisAction extends Action
{
    /**
     * @var PaisRepository
     */
    protected $PaisRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param PaisRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, PaisRepository $PaisRepository)
    {
        parent::__construct($logger);
        $this->PaisRepository = $PaisRepository;
    }
}
