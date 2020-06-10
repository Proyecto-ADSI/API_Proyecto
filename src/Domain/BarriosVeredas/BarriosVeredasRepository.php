<?php
declare(strict_types=1);

namespace App\Domain\BarriosVeredas;

interface BarriosVeredasRepository {

    public function RegistrarBarriosVeredas(BarriosVeredas $BarriosVeredas);

    public function ListarBarriosVeredas();

    public function CambiarEstado(int $Id_Barrios_Veredas, int $Estado);

    public function ObtenerDatosBarriosVeredas(int $Id_Barrios_Veredas);

    public function ConsultarBarriosVeredasMunicipio(int $Id_Municipio, int $Id_SubTipo);

    public function EditarBarriosVeredas(BarriosVeredas $BarriosVeredas);

    public function ValidarBarriosVeredas(int $Id_Barrios_Veredas);

    public function EliminarBarriosVeredas(int $Id_Barrios_Veredas);
}