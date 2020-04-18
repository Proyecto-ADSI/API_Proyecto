<?php
declare(strict_types=1);

namespace App\Domain\Linea;

interface LineaRepository{

    public function RegistrarLinea(Linea $linea);

    public function ConsultarUltimaLinea();

    public function EditarLinea(Linea $linea);

    public function RegistrarDetalleLinea(int $IdLinea, int $IdDBL);
}