<?php
declare(strict_types=1);

namespace App\Domain\Visitas;

interface VisitasRepository {

    public function RegistrarVisitas(Visitas $Visitas);

}