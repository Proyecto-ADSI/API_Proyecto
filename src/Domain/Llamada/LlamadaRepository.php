<?php
declare(strict_types=1);

namespace App\Domain\Llamada;

interface LlamadaRepository{

    public function RegistrarLlamada(Llamada $Llamada);

    public function ListarLlamadas();
    
    public function ConsultarUltimaLlamada();
    
}