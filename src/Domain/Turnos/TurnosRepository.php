<?php
declare(strict_types=1);

namespace App\Domain\Turnos;

interface TurnosRepository {

    public function RegistrarTurnos(Turnos $Turnos);

    public function ListarTurno();

    public function CambiarEstado(int $Id_Turno, int $Estado);

    public function ObtenerDatosTurno(int $Id_Turno);

    public function EditarTurno(Turnos $Turnos);

    public function ValidarEliminarTurno(int $Id_Turno);

    public function EliminarTurno(int $Id_Turno);
}