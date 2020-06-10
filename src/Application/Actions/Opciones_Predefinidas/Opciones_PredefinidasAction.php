<?php

declare(strict_types=1);

namespace App\Application\Actions\Opciones_Predefinidas;

use App\Application\Actions\Action;
use App\Domain\Opciones_Predefinidas\Opciones_PredefinidasRepository;
use Psr\Log\LoggerInterface;

abstract class Opciones_PredefinidasAction extends Action
{
    /**
     * @var Opciones_PredefinidasRepository
     */
    protected $Opciones_PredefinidasRepository;

    /**
     * @param LoggerInterface $logger
     * @param Opciones_PredefinidasRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, Opciones_PredefinidasRepository $Opciones_PredefinidasRepository)
    {
        parent::__construct($logger);
        $this->Opciones_PredefinidasRepository = $Opciones_PredefinidasRepository;
    }
}
