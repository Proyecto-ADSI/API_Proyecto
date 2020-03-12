<?php
declare(strict_types=1);

namespace App\Application\Actions\Operador;

use App\Application\Actions\Action;
use App\Domain\Operador\OperadorRepository;
use Psr\Log\LoggerInterface;

abstract class OperadorAction extends Action
{
    /**
     * @var OperadorRepository
     */
    protected $OperadorRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param OperadorRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, OperadorRepository $OperadorRepository)
    {
        parent::__construct($logger);
        $this->OperadorRepository = $OperadorRepository;
    }
}
