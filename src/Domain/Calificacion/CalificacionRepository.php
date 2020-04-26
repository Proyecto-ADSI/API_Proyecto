<?php

declare(strict_types = 1);

namespace App\Domain\Calificacion;

interface CalificacionRepository {

    public function RegistrarCalificacion(Calificacion $Calificacion);

    public function ListarCalificacion();

    public function CambiarEstado(int $Id_Calificacion, int $Estado);

    public function ObtenerDatosCalificacion(int $Id_Calificacion);

    public function EditarCalificacion(Calificacion $Calificacion);

    public function EliminarCalificacion(int $Id_Calificacion);
    
    public function ValidarEliminarCalificacion(int $Id_Calificacion);
}