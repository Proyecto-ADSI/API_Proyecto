<?php
declare(strict_types=1);

namespace App\Domain\Visitas;

interface VisitasRepository {

    public function RegistrarVisitas(Visitas $Visitas);

    public function ListarVisitas();

    public function ListarTiempoFin();

    public function ListarOperadoresVisitas();

}