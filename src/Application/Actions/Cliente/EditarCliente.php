<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\DBL\DBL;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Domain\Linea\Linea;
use App\Domain\Lineas_Fijas\Lineas_Fijas;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use Psr\Http\Message\ResponseInterface as Response;

class EditarCliente extends ClienteAction
{

    protected function action(): Response
    {
        $campos = $this->getFormData();

        // Crear datos básicos líneas.
        $DBL = new DBL(
            $campos->Id_DBL,
            $campos->Id_Cliente,
            $campos->Id_Operador,
            NULL,
            $campos->Cantidad_Lineas,
            $campos->Valor_Mensual,
            $campos->Id_Calificacion_Operador,
            $campos->Razones,
            NULL
        );

        if (isset($campos->Id_Plan_Corporativo)) {
            $Id_Plan_Corporativo = (int) $campos->Id_Plan_Corporativo;
        }

        if (isset($campos->Id_Documentos)) {
            $Id_Documentos = (int) $campos->Id_Documentos;
        }

        // Validar si se edita o registra el plan corporativo
        if ($campos->Validacion_PLan_C) {

            // Crear plan corporativo
            $Plan_Corporativo = new Plan_Corporativo(
                NULL,
                NULL,
                $campos->Fecha_Inicio,
                $campos->Fecha_Fin,
                $campos->Clausula,
                $campos->Descripcion,
                NULL
            );



            // Validar si se editan o registran los documentos soporte
            if ($campos->Validacion_Doc_S) {


                $Doc_Soporte = new Doc_Soporte(
                    NULL,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );


                if ($Id_Documentos > 0) {
                    // Editar documentos
                    $Doc_Soporte->__set("Id_Documentos", $Id_Documentos);
                    $Plan_Corporativo->__set("Id_Documentos", $Id_Documentos);
                    $this->Doc_SoporteRepository->EditarDocSoporte($Doc_Soporte);
                } else {

                    // Registrar ducumentos
                    $this->Doc_SoporteRepository->RegistrarDocSoporte($Doc_Soporte);
                    $InfoIdDoc = $this->Doc_SoporteRepository->ConsultarUltimoRegistrado();
                    $Id_Documentos = (int) $InfoIdDoc['Id_Documentos'];
                    $Plan_Corporativo->__set("Id_Documentos", $Id_Documentos);
                }

                if ($Id_Plan_Corporativo > 0) {
                    // Editar plan corporativo con documentos.
                    $Plan_Corporativo->__set("Id_Plan_Corporativo", $Id_Plan_Corporativo);
                    $this->Plan_CorporativoRepository->EditarPlan_Corporativo($Plan_Corporativo);
                } else {
                    // Registrar plan corporativo con documentos.
                    $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
                    $InfoIdPlan = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();
                    $Id_Plan_Corporativo = (int) $InfoIdPlan['Id_Plan_Corporativo'];
                }
            } else {

                if ($Id_Plan_Corporativo > 0) {
                    // Editar plan corporativo sin documentos.
                    $Plan_Corporativo->__set("Id_Plan_Corporativo", $Id_Plan_Corporativo);
                    $this->Plan_CorporativoRepository->EditarPlan_Corporativo($Plan_Corporativo);
                    if (isset($Id_Documentos)) {
                        $this->Doc_SoporteRepository->EliminarDocSoporte($Id_Documentos);
                    }
                } else {
                    // Registrar plan corporativo sin documentos.
                    $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
                    $InfoIdPlan = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();
                    $Id_Plan_Corporativo = (int) $InfoIdPlan['Id_Plan_Corporativo'];
                }
            }

            // Editar Datos básicos líneas con plan corporativo
            $DBL->__set("Id_Plan_Corporativo", $Id_Plan_Corporativo);
            $this->DBLRepository->EditarDBL($DBL);
        } else {

            // Editar Datos básicos líneas sin plan corporativo
            $this->DBLRepository->EditarDBL($DBL);
            if (isset($Id_Plan_Corporativo)) {
                $this->Plan_CorporativoRepository->EliminarPlan_Corporativo($Id_Plan_Corporativo);
            }
            if (isset($Id_Documentos)) {
                $this->Doc_SoporteRepository->EliminarDocSoporte($Id_Documentos);
            }
        }

        // Servicios fijos
        $serviciosFijos = $campos->ServiciosFijos;
        if (isset($serviciosFijos)) {

            $lineasFijas = new Lineas_Fijas(
                $serviciosFijos->id_linea_fija,
                $serviciosFijos->pagina,
                $serviciosFijos->correo,
                $serviciosFijos->ip,
                $serviciosFijos->dominio,
                $serviciosFijos->telefonia,
                $serviciosFijos->television
            );

            $this->Lineas_FijasRepository->EditarLineas_Fijas($lineasFijas);
        }


        // Servicios móviles
        $arrayLineas = $campos->ServiciosMoviles;
        // Validar si tiene líneas móviles ya registradas.
        $infoDetalleLineaMoviles = $this->DBLRepository->ConsultarDetalleLineas($campos->Id_DBL);

        if (!empty($infoDetalleLineaMoviles)) {

            // Eliminar líneas móviles registradas.
            $this->DBLRepository->EliminarDetalleLineasMoviles($campos->Id_DBL);

            foreach ($infoDetalleLineaMoviles as $linea) {

                $Id_Linea = (int) $linea['Id_Linea_Movil'];

                $this->LineaRepository->EliminarLinea($Id_Linea);
            }

            // Agregar nuevas lineas a la tabla.
            foreach ($arrayLineas as $lineaItem) {

                $linea = new Linea(
                    NULL,
                    NULL,
                    $lineaItem->minutos,
                    $lineaItem->navegacion,
                    $lineaItem->mensajes,
                    $lineaItem->redes,
                    $lineaItem->minutosLDI,
                    $lineaItem->cantidadLDI,
                    $lineaItem->serviciosAdicionales,
                    $lineaItem->cargoBasicoMensual,
                    $lineaItem->grupo
                );

                if ($lineaItem->numero !== "0") {
                    $linea->__set("Linea", $lineaItem->numero);
                }

                $this->LineaRepository->RegistrarLinea($linea);
                $infoIdLinea = $this->LineaRepository->ConsultarUltimaLinea();
                $this->LineaRepository->RegistrarDetalleLinea((int) $infoIdLinea['Id_Linea_Movil'], $campos->Id_DBL);
            }
        }

        // Editar Cliente
        $Cliente = new Cliente(
            $campos->Id_Cliente,
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Extension,
            $campos->Encargado,
            $campos->Correo,
            $campos->Celular,
            $campos->Direccion,
            $campos->Barrio_Vereda,
            NULL
        );

        $respuesta = $this->ClienteRepository->EditarCliente($Cliente);

        // Respuesta es TRUE || FALSE
        return $this->respondWithData(["ok" => $respuesta]);
    }
}
