<?php
declare(strict_types=1);

namespace App\Application\Actions\Sexo;

use App\Application\Actions\Action;
use App\Domain\Sexo\SexoRepository;
use Psr\Log\LoggerInterface;

abstract class SexoAction extends Action
{
    /**
     * @var SexoRepository
     */
    protected $SexoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param SexoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, SexoRepository $SexoRepository)
    {
        parent::__construct($logger);
        $this->SexoRepository = $SexoRepository;
    }
}
