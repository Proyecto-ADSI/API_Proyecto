<?php
declare(strict_types=1);

namespace App\Domain\BarriosVeredas;

interface BarriosVeredasRepository {

    public function RegistrarBarriosVeredas(BarriosVeredas $BarriosVeredas);

    public function ListarBarriosVeredas();

    public function CambiarEstado(int $Id_Barrios_Veredas, int $Estado);

    public function ObtenerDatosBarriosVeredas(int $Id_Barrios_Veredas);

    public function EditarBarriosVeredas(BarriosVeredas $BarriosVeredas);
}