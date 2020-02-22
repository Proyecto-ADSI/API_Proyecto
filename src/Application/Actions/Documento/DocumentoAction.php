<?php
declare(strict_types=1);

namespace App\Application\Actions\Documento;

use App\Application\Actions\Action;
use App\Domain\Documento\DocumentoRepository;
use Psr\Log\LoggerInterface;

abstract class DocumentoAction extends Action
{
    /**
     * @var DocumentoRepository
     */
    protected $DocumentoRepository;
    
    /**
     * @param LoggerInterface $logger
     * @param DocumentoRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, DocumentoRepository $DocumentoRepository)
    {
        parent::__construct($logger);
        $this->DocumentoRepository = $DocumentoRepository;
    }
}
