<?php
declare(strict_types=1);

namespace App\Domain\Municipio;

interface MunicipioRepository{

    public function RegistrarMunicipio(Municipio $Municipio);

    public function ListarMunicipio();

    public function CambiarEstado(int $Id_Municipios, int $Estado);

    public function ObtenerDatosMunicipio(int $Id_Municipios);

    public function EditarMunicipio(Municipio $Municipio);
}