<?php

declare(strict_types=1);

namespace App\Domain\DBL;

interface DBLRepository
{

    public function RegistrarDBL(DBL $DBL);

    public function ListarDBL(int $Id_Cliente, int $Estado_DBL);

    public function ObtenerDBL(int $Id_DBL);
    
    public function EditarDBL(DBL $DBL);

    public function CambiarEstadoDBL(int $Id_DBL, int $Estado);

    public function ELiminarDBL(int $Id_DBL);

    public function ConsultarUltimoRegistrado();

    public function ConsultarDetalleLineas(int $DBL);

    public function ConsultarDetalleLineasFijas(int $DBL);

    public function EliminarDetalleLineas(int $Id_DBL);

    public function EliminarDetalleLineasMoviles(int $Id_DBL);
}
