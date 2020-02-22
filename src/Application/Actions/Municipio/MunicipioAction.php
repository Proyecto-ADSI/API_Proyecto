<?php
declare(strict_types=1);

namespace App\Application\Actions\Municipio;

use App\Application\Actions\Action;
use App\Domain\Municipio\MunicipioRepository;
use Psr\Log\LoggerInterface;

abstract class MunicipioAction extends Action
{
    /**
     * @var MunicipioRepository
     */
    protected $MunicipioRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param MunicipioRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, MunicipioRepository $MunicipioRepository)
    {
        parent::__construct($logger);
        $this->MunicipioRepository = $MunicipioRepository;
    }
}
