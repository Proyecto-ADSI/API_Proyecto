<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\DBL\DBL;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarCliente extends ClienteAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();


        // Cliente
        $Cliente = new Cliente(
            0,
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Direccion,
            $campos->Departamento,
            $campos->Municipio,
            $campos->Barrio_Vereda,
            $campos->Nombre_Lugar,
            $campos->Estado_Cliente
        );
        
        $this->ClienteRepository->RegistrarCliente($Cliente);

        $InfoIdCliente = $this->ClienteRepository->ConsultarUltimoRegistrado();

        // Validar si se registra el plan corporativo

        if($campos->Validacion_PLan_C){
            
            if($campos->Validacion_Doc_S){

                $Doc_Soporte = new Doc_Soporte(
                    Null,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );

                $this->Doc_SoporteRepository->RegistrarDocSoporte($Doc_Soporte);

                $InfoIdDoc = $this->Doc_SoporteRepository->ConsultarUltimoRegistrado();
                
                $Plan_Corporativo = new Plan_Corporativo(
                        NULL,
                        (int) $InfoIdDoc['Id_Documentos'],
                        $campos->Fecha_Inicio,
                        $campos->Fecha_Fin,
                        $campos->Descripcion,
                        $campos->Estado_Plan_Corporativo,
                );

                $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);


            }else{

                // Plan Corporativo sin documentos
                $Plan_Corporativo = new Plan_Corporativo(
                    NULL,
                    NULL,
                    $campos->Fecha_Inicio,
                    $campos->Fecha_Fin,
                    $campos->Descripcion,
                    $campos->Estado_Plan_Corporativo);

                    $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            }

             // Datos básicos líneas con plan corporativo

                $InfoIdPlan = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();
                
                $DBL = new DBL(
                    NULL,
                    (int) $InfoIdCliente['Id_Cliente'],
                    $campos->Id_Operador,
                    (int) $InfoIdPlan['Id_Plan_Corporativo'],
                    $campos->Encargado,
                    $campos->Extension,
                    $campos->Telefono_Contacto,
                    $campos->Cantidad_Lineas,
                    $campos->Valor_Mensual,
                    $campos->Cantidad_Minutos,
                    $campos->Cantidad_Navegacion,
                    $campos->Llamadas_Internacionales,
                    $campos->Mensajes_Texto,
                    $campos->Aplicaciones,
                    $campos->Roaming_Internacional,
                    $campos->Estado_DBL
                );

                $r = $this->DBLRepository->RegistrarDBL($DBL);

                return $this->respondWithData(["ok"=>$r]);

        }else{
        
            // Datos básicos líneas sin plan corporativo
            $DBL = new DBL(
                NULL,
                (int) $InfoIdCliente['Id_Cliente'],
                $campos->Id_Operador,
                NULL,
                $campos->Encargado,
                $campos->Extension,
                $campos->Telefono_Contacto,
                $campos->Cantidad_Lineas,
                $campos->Valor_Mensual,
                $campos->Cantidad_Minutos,
                $campos->Cantidad_Navegacion,
                $campos->Llamadas_Internacionales,
                $campos->Mensajes_Texto,
                $campos->Aplicaciones,
                $campos->Roaming_Internacional,
                $campos->Estado_DBL
            );

            $r = $this->DBLRepository->RegistrarDBL($DBL);

            return $this->respondWithData(["ok"=>$r]);
        }  
    }
}

