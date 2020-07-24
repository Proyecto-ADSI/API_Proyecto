<?php

declare(strict_types=1);

namespace App\Domain\Cita;

interface CitaRepository
{

    public function RegistrarCita(Cita $Cita);

    public function ConsultarUltimaCitaRegistrada();

    public function ListarCita();

    public function CambiarEstadoRC(int $Id_Cita, int $Estado);

    public function ListarCitaSinAsignar();

    public function ListarAsesoresInternos();

    public function ListarAsesoresExternos();

    public function EditarCita(int $Id_Cita, string $Encargado, string $Ext_Tel, int $Representante, string $Fecha_Cita, string $Direccion, int $Id_Barrios_Vereda, string $Lugar_Referencia, int $Id_Operador);

    public function ListarHorasCitas(int $Id_Operador, string $Fecha);

    public function FiltrarAsesoresEx(string $texto);

}
