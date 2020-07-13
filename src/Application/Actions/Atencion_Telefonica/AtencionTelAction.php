<?php
declare(strict_types=1);

namespace App\Application\Actions\Atencion_Telefonica;

use App\Application\Actions\Action;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use Psr\Log\LoggerInterface;

abstract class AtencionTelAction extends Action
{
    /**
     * @var AtencionTelefonicaRepository
     */
    protected $AtencionTelefonicaRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param AtencionTelefonicaRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, AtencionTelefonicaRepository $AtencionTelefonicaRepository)
    {
        parent::__construct($logger);
        $this->AtencionTelefonicaRepository = $AtencionTelefonicaRepository;
    }
}
