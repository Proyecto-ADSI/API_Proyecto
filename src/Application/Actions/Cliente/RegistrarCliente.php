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

        // return $this->respondWithData(["ok" => $campos]);


        // Validar si se registra el plan corporativo

        if ($campos->Validacion_PLan_C) {

            if ($campos->Validacion_Doc_S) {

                // Registrar documentos

                $Doc_Soporte = new Doc_Soporte(
                    Null,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );

                $this->Doc_SoporteRepository->RegistrarDocSoporte($Doc_Soporte);

                $InfoIdDoc = $this->Doc_SoporteRepository->ConsultarUltimoRegistrado();

                // Registrar plan corporativo

                $Plan_Corporativo = new Plan_Corporativo(
                    NULL,
                    (int) $InfoIdDoc['Id_Documentos'],
                    $campos->Fecha_Inicio,
                    $campos->Fecha_Fin,
                    $campos->Descripcion,
                    $campos->Estado_Plan_Corporativo,
                );

                $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            } else {
                
                // Plan Corporativo sin documentos
                $Plan_Corporativo = new Plan_Corporativo(
                    NULL,
                    NULL,
                    $campos->Fecha_Inicio,
                    $campos->Fecha_Fin,
                    $campos->Descripcion,
                    $campos->Estado_Plan_Corporativo
                );

                $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            }

            // Datos básicos líneas con plan corporativo

            $InfoIdPlan = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();

            $DBL = new DBL(
                NULL,
                $campos->Id_Operador,
                (int) $InfoIdPlan['Id_Plan_Corporativo'],
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

            $this->DBLRepository->RegistrarDBL($DBL);

        } else {

            // Datos básicos líneas sin plan corporativo
            $DBL = new DBL(
                NULL,
                $campos->Id_Operador,
                NULL,
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

            $this->DBLRepository->RegistrarDBL($DBL);
        }


        //Id_Datos_Basicos_Lineas
        $InfoIdDBL = $this->DBLRepository->ConsultarUltimoRegistrado();

        // Registrar Cliente
        $Cliente = new Cliente(
            NULL,
            (int)$InfoIdDBL['Id_DBL'],
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Encargado,
            $campos->Extension,
            $campos->Telefono_Contacto,
            $campos->Direccion,
            $campos->Barrio_Vereda,
            $campos->Estado_Cliente
        );  

        $respuesta = $this->ClienteRepository->RegistrarCliente($Cliente);

        // Respuesta es TRUE || FALSE
        return $this->respondWithData(["ok" => $respuesta]);
    }
}
