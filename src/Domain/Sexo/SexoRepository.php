<?php
declare(strict_types=1);

namespace App\Domain\Sexo;

interface SexoRepository{

    public function RegistrarSexo(Sexo $Sexo);

    public function ListarSexo();

    public function CambiarEstado(int $Id_Sexo, int $Estado);

    public function ObtenerDatos(int $Id_Sexo);

    public function EditarSexo(Sexo $Sexo);
}