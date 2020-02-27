<?php
declare(strict_types=1);

namespace App\Application\Actions\Rol;

use App\Application\Actions\Action;
use App\Domain\Rol\RolRepository;
use Psr\Log\LoggerInterface;

abstract class RolAction extends Action
{
    /**
     * @var RolRepository
     */
    protected $RolRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param RolRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, RolRepository $RolRepository)
    {
        parent::__construct($logger);
        $this->RolRepository = $RolRepository;
    }
}
