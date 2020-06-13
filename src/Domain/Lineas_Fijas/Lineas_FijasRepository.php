<?php

declare(strict_types=1);

namespace App\Domain\Lineas_Fijas;

interface Lineas_FijasRepository
{

    public function RegistrarLineas_Fijas(Lineas_Fijas $Lineas_Fijas);

    public function ConsultarUltimaLineas_Fijas();

    public function EditarLineas_Fijas(Lineas_Fijas $Lineas_Fijas);

    public function EliminarLineas_Fijas(int $IdLinea_Fija);

    public function RegistrarDetalleLineas_Fijas(int $IdLineas_Fijas, int $IdDBL);
}
