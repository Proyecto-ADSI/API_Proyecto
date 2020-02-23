<?php
declare(strict_types=1);

namespace App\Application\Actions\Departamento;

use App\Application\Actions\Action;
use App\Domain\Departamento\DepartamentoRepository;
use Psr\Log\LoggerInterface;

abstract class DepartamentoAction extends Action
{
    /**
     * @var DepartamentoRepository
     */
    protected $DepartamentoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param DepartamentoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, DepartamentoRepository $DepartamentoRepository)
    {
        parent::__construct($logger);
        $this->DepartamentoRepository = $DepartamentoRepository;
    }
}
