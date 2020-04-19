<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerCliente extends ClienteAction
{
    private $Cliente;
    private $DBL;
    private $Plan_Corporativo;
    private $Documentos_Soporte;
    private $Info_Cliente;
    private $Ubicacion;
    private $DetalleLineas;

    protected function action(): Response
    {
        // Obtener información del cliente
        $Id_Cliente = (int) $this->resolveArg("Id_Cliente");
        $this->Cliente = $this->ClienteRepository->ObtenerCliente($Id_Cliente);

        

        // Información de ubicación
        $Id_BarrioVereda = (int) $this->Cliente['Id_Barrios_Veredas'];

        if ($Id_BarrioVereda > 0) {

            $BarrioVereda = $this->BarriosVeredasRepository->ObtenerDatosBarriosVeredas($Id_BarrioVereda);

            $Id_SubTipo = (int) $BarrioVereda['Id_SubTipo_Barrio_Vereda'];
            $SubTipo = $this->SubTipoRepository->ObtenerDatosSubTipo($Id_SubTipo);

            $Id_Municipio = (int) $BarrioVereda['Id_Municipio'];
            $Municipio = $this->MunicipioRepository->ObtenerDatosMunicipio($Id_Municipio);

            $Id_Departamento = (int) $Municipio['Id_Departamento'];
            $Departamento = $this->DepartamentoRepository->ObtenerDatosDepartamento($Id_Departamento);

            $Id_Pais = (int) $Departamento['Id_Pais'];
            $Pais = $this->PaisRepository->ObtenerDatos($Id_Pais);

            $this->Ubicacion =  array_merge($BarrioVereda, $SubTipo, $Municipio, $Departamento, $Pais);

            
        }

        // Obtener datos básicos de lineas del cliente

        $this->DBL = $this->DBLRepository->ListarDBL($Id_Cliente,1);
   
        // Validar si tiene plan corporativo
        $Id_Plan_Corporativo = (int) $this->DBL["Id_Plan_Corporativo"];

        if ($Id_Plan_Corporativo > 0) {

            // Obtener información de plan corporativo
            $this->Plan_Corporativo = $this->Plan_CorporativoRepository->ListarPlan_Corporativo($Id_Plan_Corporativo);

            // Validar si tiene documentos soporte
            $Id_Documentos = (int) $this->Plan_Corporativo["Id_Documentos"];

            if ($Id_Documentos > 0) {
                // Obtener información de documentos
                $this->Documentos_Soporte = $this->Doc_SoporteRepository->ListarDocSoporte($Id_Documentos);

                // Array con toda la información.
                $this->Info_Cliente = array_merge($this->Cliente, $this->DBL, $this->Plan_Corporativo, $this->Documentos_Soporte);
            } else {
                // Array sin documentos
                $this->Info_Cliente = array_merge($this->Cliente, $this->DBL, $this->Plan_Corporativo);
            }
        } else {

            // Array sin plan corporativo y documentos.
            $this->Info_Cliente = array_merge($this->Cliente, $this->DBL);
        }

        // Agregar información de ubicación
        if(!empty($this->Ubicacion)){

            $this->Info_Cliente = array_merge($this->Info_Cliente, $this->Ubicacion);
        }

        // Agregar detalle líneas.
        $this->DetalleLineas = $this->DBLRepository->ConsultarDetalleLineas( (int) $this->DBL["Id_DBL"]);;


        if(!empty($this->DetalleLineas)){

            $arrayDetalle = array(
                'Detalle_Lineas' => $this->DetalleLineas
            );

            $this->Info_Cliente = array_merge($this->Info_Cliente,$arrayDetalle);

        }   

        return  $this->respondWithData($this->Info_Cliente);
        
    }
}
