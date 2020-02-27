<?php
declare(strict_types=1);

namespace App\Application\Actions\SubTipo;

use App\Application\Actions\Action;
use App\Domain\SubTipo\SubTipoRepository;
use Psr\Log\LoggerInterface;

abstract class SubTipoAction extends Action
{
    /**
     * @var SubTipoRepository
     */
    protected $SubTipoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param SubTipoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, SubTipoRepository $SubTipoRepository)
    {
        parent::__construct($logger);
        $this->SubTipoRepository = $SubTipoRepository;
    }
}
