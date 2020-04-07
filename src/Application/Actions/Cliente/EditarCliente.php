<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\DBL\DBL;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use Psr\Http\Message\ResponseInterface as Response;
class EditarCliente extends ClienteAction {

    protected function action(): Response
    {
        $campos = $this->getFormData();

        // Validar si se edita el plan corporativo

        if ($campos->Validacion_PLan_C) {

            // Validar si se editan los documentos soporte
            if ($campos->Validacion_Doc_S) {

                // Editar documentos

                $Doc_Soporte = new Doc_Soporte(
                    $campos->Id_Documentos,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );

                $this->Doc_SoporteRepository->EditarDocSoporte($Doc_Soporte);

                // Editar plan corporativo

                $Plan_Corporativo = new Plan_Corporativo(
                    $campos->Id_Plan_Corporativo,
                    $campos->Id_Documentos,
                    $campos->Fecha_Inicio,
                    $campos->Fecha_Fin,
                    $campos->Descripcion,
                    NULL
                );

                $this->Plan_CorporativoRepository->EditarPlan_Corporativo($Plan_Corporativo);
            } else {

                // Editar Plan Corporativo sin editar documentos
                $Plan_Corporativo = new Plan_Corporativo(
                    $campos->Id_Plan_Corporativo,
                    null,
                    $campos->Fecha_Inicio,
                    $campos->Fecha_Fin,
                    $campos->Descripcion,
                    NULL
                );

                $this->Plan_CorporativoRepository->EditarPlan_Corporativo($Plan_Corporativo);
            }

            // Editar Datos básicos líneas con plan corporativo

            $DBL = new DBL(
                $campos->Id_DBL,
                $campos->Id_Operador,
                $campos->Id_Plan_Corporativo,
                $campos->Cantidad_Lineas,
                $campos->Valor_Mensual,
                $campos->Cantidad_Minutos,
                $campos->Cantidad_Navegacion,
                $campos->Llamadas_Internacionales,
                $campos->Mensajes_Texto,
                $campos->Aplicaciones,
                $campos->Roaming_Internacional,
                NULL
            );

            $this->DBLRepository->EditarDBL($DBL);

        } else {

            // Editar Datos básicos líneas sin plan corporativo
            $DBL = new DBL(
                $campos->Id_DBL,
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
                NULL
            );

            $this->DBLRepository->EditarDBL($DBL);
        }

        // Editar Cliente
        $Cliente = new Cliente(
            $campos->Id_Cliente,
            $campos->Id_DBL,
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Encargado,
            $campos->Extension,
            $campos->Telefono_Contacto,
            $campos->Direccion,
            $campos->Id_Barrios_Veredas,
            NULL
        );

        $respuesta = $this->ClienteRepository->EditarCliente($Cliente);

        // Respuesta es TRUE || FALSE
        return $this->respondWithData(["ok" => $respuesta]);
    }   

}