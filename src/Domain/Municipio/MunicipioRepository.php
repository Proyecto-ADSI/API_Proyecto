<?php
declare(strict_types=1);

namespace App\Domain\Municipio;

interface MunicipioRepository{

    public function RegistrarMunicipio(Municipio $Municipio);

    public function ListarMunicipio();

    public function ListarMunicipiosFiltro(string $texto);

    public function CambiarEstado(int $Id_Municipios, int $Estado);

    public function ObtenerDatosMunicipio(int $Id_Municipios);

    public function ValidarEliminarMunicipio(int $Id_Municipios);

    public function EliminarMunicipio(int $Id_Municipios);

    public function ConsultarMunicipiosDepartamento(int $Id_Departamento);

    public function EditarMunicipio(Municipio $Municipio);
}