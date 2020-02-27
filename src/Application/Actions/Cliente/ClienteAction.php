<?php
declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Application\Actions\Action;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use Psr\Log\LoggerInterface;

abstract class ClienteAction extends Action
{
    
    protected $ClienteRepository;
    protected $DBLRepository;
    protected $Plan_CorporativoRepository;
    protected $Doc_SoporteRepository;
    
    public function __construct(LoggerInterface $logger, ClienteRepository $ClienteRepository, 
    DBLRepository $DBLRepository,Plan_CorporativoRepository $Plan_CorporativoRepository,
    Doc_SoporteRepository $Doc_SoporteRepository)
    {
        parent::__construct($logger);
        $this->ClienteRepository = $ClienteRepository;
        $this->DBLRepository = $DBLRepository;
        $this->Plan_CorporativoRepository = $Plan_CorporativoRepository;
        $this->Doc_SoporteRepository = $Doc_SoporteRepository;
    }
}
