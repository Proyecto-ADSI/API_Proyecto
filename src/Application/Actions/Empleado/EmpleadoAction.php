<?php
declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use App\Application\Actions\Action;
use App\Domain\Empleado\EmpleadoRepository;
use Psr\Log\LoggerInterface;

abstract class EmpleadoAction extends Action
{
    /**
     * @var EmpleadoRepository
     */
    protected $EmpleadoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param EmpleadoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, EmpleadoRepository $EmpleadoRepository)
    {
        parent::__construct($logger);
        $this->EmpleadoRepository = $EmpleadoRepository;
    }
}
