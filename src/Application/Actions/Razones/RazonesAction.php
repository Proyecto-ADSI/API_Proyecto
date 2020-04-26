<?php
declare(strict_types=1);

namespace App\Application\Actions\Razones;

use App\Application\Actions\Action;
use App\Domain\Razones\RazonesRepository;
use Psr\Log\LoggerInterface;

abstract class RazonesAction extends Action
{
    /**
     * @var RazonesRepository
     */
    protected $RazonesRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param RazonesRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, RazonesRepository $RazonesRepository)
    {
        parent::__construct($logger);
        $this->RazonesRepository = $RazonesRepository;
    }
}
