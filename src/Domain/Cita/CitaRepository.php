<?php
declare(strict_types=1);

namespace App\Domain\Cita;

interface CitaRepository{

    public function RegistrarCita(Cita $Cita);

    public function ConsultarUltimaCitaRegistrada();
}