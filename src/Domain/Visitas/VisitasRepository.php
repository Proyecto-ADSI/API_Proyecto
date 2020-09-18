<?php
declare(strict_types=1);

namespace App\Domain\Visitas;
use App\Domain\Datos_Visita\Datos_Visita;

interface VisitasRepository {

    public function RegistrarVisitas(Visitas $Visitas);

    public function ListarVisitas();

    public function ListarTiempoFin();

    public function ListarOperadoresVisitas();

    public function ListarVisitas_V2();

    public function ObtenerCliente_Visitas(string $NIT);

    public function ListarEstados();

    public function ModificarVisita(int $Id, int $Estado, int $Id_Datos_Visita);

    public function RegistrarDatosVisita(Datos_Visita $Datos_Visita);

    public function CambiarEstado(int $Id, int $Estado);

}