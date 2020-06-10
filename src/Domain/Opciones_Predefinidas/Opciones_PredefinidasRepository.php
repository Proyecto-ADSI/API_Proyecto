<?php

declare(strict_types=1);

namespace App\Domain\Opciones_Predefinidas;

interface Opciones_PredefinidasRepository
{

    public function RegistrarOpcionesP(Opciones_Predefinidas $Opciones_Predefinidas);

    public function ListarOpcionesP();

    public function ListarOpcionesPCategoria(string $Categoria);

    public function ObtenerDatosOpcionesP(int $Id_Opcion_Predefinida);

    public function EditarOpcionesP(Opciones_Predefinidas $Opciones_Predefinidas);

    public function EliminarOopcionesP(int $Id_Opcion_Predefinida);
}
