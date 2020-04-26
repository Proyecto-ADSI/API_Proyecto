<?php

declare(strict_types = 1);

namespace App\Domain\Razones;

interface RazonesRepository {

    public function RegistrarRazones(Razones $Razones);

    public function ListarRazones();

    public function ObtenerDatosRazones(int $Id_Razones);

    public function EditarRazones(Razones $Razones);

    public function EliminarRazones(int $Id_Razones);
    
}