<?php
declare(strict_types=1);

namespace App\Domain\Pais;

interface PaisRepository {

    public function RegistrarPais(Pais $Pais);

    public function ListarPais();

    public function CambiarEstado(int $Id_Pais, int $Estado);

    public function ObtenerDatos(int $Id_Pais);

    public function EditarPais(Pais $Pais);
}