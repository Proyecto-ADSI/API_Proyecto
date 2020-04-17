<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class CargarDatosUbicacion extends ClienteAction
{
    protected function action(): Response
    {
        $DatosUbicacion = [];

        $paises = $this->PaisRepository->ListarPais();

        $arrayPaises = array(
            'Paises' => $paises
        );

        $departamentos = $this->DepartamentoRepository->ListarDepartamento();

        $arraDepartamentos = array(
            'Departamentos' => $departamentos
        );

        $municipios = $this->MunicipioRepository->ListarMunicipio();
        
        $arrayMunicipios =array(

            'Municipios' => $municipios
        );

        $subtipos = $this->SubTipoRepository->ListarSubTipo();

        $arraySubtipo = array(
            'Subtipos' => $subtipos
        );

        $barrios_veredas = $this->BarriosVeredasRepository->ListarBarriosVeredas();

        $arrayBarriosVeredas = array(
            'Barrios_Veredas' => $barrios_veredas
        );

        $DatosUbicacion = array_merge($DatosUbicacion,$arrayPaises,$arraDepartamentos,$arrayMunicipios,$arraySubtipo,$arrayBarriosVeredas);
        
        return $this->respondWithData($DatosUbicacion);
    }
}

