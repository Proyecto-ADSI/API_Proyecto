<?php
declare(strict_types=1);

namespace App\Domain\Llamada_Programada;

interface Llamada_ProgramadaRepository{

    public function RegistrarLlamada_Programada(Llamada_Programada $Llamada_Programada);

}