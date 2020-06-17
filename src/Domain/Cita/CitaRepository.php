<?php
declare(strict_types=1);

namespace App\Domain\Cita;

interface CitaRepository{

    public function RegistrarCita(Cita $Cita);

    public function ConsultarUltimaCitaRegistrada();

    public function ListarCita();

    public function CambiarEstadoRC(int $Id_Cita, int $Estado);

    public function CambiarEstadoV(int $Id_Cita, int $EstadoV);

    public function ListarCitaSinAsignar();

    public function ListarAsesoresInternos();

}