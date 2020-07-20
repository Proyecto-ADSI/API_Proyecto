<?php

declare(strict_types=1);

namespace App\Domain\Operador;

use App\Domain\Operador\Operador;

interface OperadorRepository
{

    public function RegistrarOperador(Operador $Operador);

    public function ListarOPerador();

    public function ListarOperadorOferta();

    public function ListarOperadoresFiltro(string $texto);

    public function CambiarEstado(int $Id_Operador, int $Estado);

    public function ObtenerDatosOperador(int $Id_Operador);

    public function EditarOperador(Operador $Operador);

    public function ValidarOperadorEliminar(int $Id_Operador);

    public function EliminarOperador(int $Id_Operador);
}
