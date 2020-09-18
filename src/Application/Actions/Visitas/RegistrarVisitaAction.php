<?php

declare(strict_types=1);

namespace App\Application\Actions\Visitas;

use Psr\Http\Message\ResponseInterface as Response;

//Models
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Domain\DBL\DBL;
use App\Domain\Linea\Linea;
use App\Domain\Oferta\Oferta;
use App\Domain\Datos_Visita\Datos_Visita;
use App\Domain\Oferta\Oferta_P;

class RegistrarVisitaAction extends VisitasAction
{

    protected function action(): Response
    {

        $campos = $this->getFormData();

        $Plan_Corporativo = $campos->PlanCorporativo;

        $Datos_Plan_Corporativo = new Plan_Corporativo(
            NULL,
            NULL,
            $Plan_Corporativo->FechaInicio,
            $Plan_Corporativo->FechaFin,
            $Plan_Corporativo->ClausulaPermanencia,
            $Plan_Corporativo->Descripcion,
            1
        );

        $Id_Plan_Corporativo = $this->PlanCorporativoRepository->RegistrarPlan_Corporativo($Datos_Plan_Corporativo);

        $DBL = $campos->DBL;

        $Datos_DBL = new DBL(
            NULL,
            $DBL->Id_Cliente,
            $DBL->Id_Operador_Oferta,
            $Id_Plan_Corporativo,
            $DBL->Cantidad_Total_Lineas,
            $DBL->Valor_Total_Mensual,
            NULL,
            NULL,
            2
        );

        $Id_DBL_Oferta = $this->DBLRepository->RegistrarDBL($Datos_DBL);

        $ServiciosMoviles = $campos->Oferta_Visita_ServiciosMoviles;


        foreach ($ServiciosMoviles as $Item) {

            $CantidadLineas = (int)$Item->Cantidad_Lineas;
            $Contador = 0;


            while ($Contador++ < $CantidadLineas) {

                $Datos_Linea = new Linea(
                    NULL,
                    NULL,
                    $Item->MinutosTD,
                    $Item->Navegacion,
                    $Item->SMSTD,
                    implode(",",$Item->ServiciosIL),
                    implode(",",$Item->MinutosLDI),
                    $Item->CantidadLDI,
                    implode(",",$Item->ServiciosAD),
                    $Item->CargoBasicoLN,
                    $Item->Grupo
                );

                $Id_Linea = $this->LineaRepository->RegistrarLinea($Datos_Linea);
                $Respuesta = $this->LineaRepository->RegistrarDetalleLinea($Id_Linea, $Id_DBL_Oferta);
                if ($Respuesta !== true) {
                    return $this->respondWithData(["ok" => false, "error" => $Respuesta]);
                }
            }
        }

        $Oferta_V = $campos->Oferta_Visita;
        $Datos_V = $campos->Datos_Visita;

        $Id_Estado_Of = 0;

        if ($Datos_V->Estado_Visita == "En negociación") {
            $Id_Estado_Of = 2;
        }
        else if ($Datos_V->Estado_Visita == "Efectiva") {
            $Id_Estado_Of = 3;
        }
        else if ($Datos_V->Estado_Visita == "No efectiva") {
            $Id_Estado_Of = 7;
        }

        $Datos_Visita = new Datos_Visita(
            NULL,
            $Datos_V->Tipo_Venta,
            $Datos_V->Calificacion,
            $Datos_V->Sugerencias,
            $Datos_V->Observacion_Datos_Visita
        );

        $Id_Datos_Visita = $this->VisitasRepository->RegistrarDatosVisita($Datos_Visita);

        $Id_Visita = $Oferta_V->Id_Visita;
        $Id_Estado_Visita = (int) $Datos_V->Id_Estado_Visita;

        $VisitaRes = $this->VisitasRepository->ModificarVisita($Id_Visita,$Id_Estado_Visita,$Id_Datos_Visita);

        if ($VisitaRes !== true) {
            return $this->respondWithData([["ok" => false, "error" => $VisitaRes]]);
        }

        $Datos_Oferta = new Oferta(
            NULL,
            NULL,
            $Oferta_V->Id_Visita,
            $Oferta_V->Id_Usuario,
            $Oferta_V->NombreCliente,
            $Oferta_V->TextoSuperior,
            $Oferta_V->TipoOferta,
            NULL,
            NULL,
            $Id_Estado_Of
    );

        $Id_Oferta = $this->OfertaRepository->RegistrarOferta($Datos_Oferta);

        $Id_DBL_Anterior = $Oferta_V->Id_DBL_Anterior;

        $Id_CoporativoAnterior = $this->OfertaRepository->RegistrarDBLAnterior($Id_DBL_Anterior);
        $Id_CorporativoActual = $this->OfertaRepository->RegistrarDBLActual($Id_DBL_Oferta);

        $Oferta_Personalizada = $campos->Ajuste_Recursos;

        $Datos_OfertaP = new Oferta_P(
            NULL,
            $Id_Oferta,
            $Id_CoporativoAnterior,
            $Id_CorporativoActual,
            $Oferta_Personalizada->BasicoNetoCl,
            $Oferta_Personalizada->BasicoNetoOf,
            $Oferta_Personalizada->ValorNetoCl,
            $Oferta_Personalizada->ValorBrutoOf,
            $Oferta_Personalizada->BonosActivacion,
            $Oferta_Personalizada->ValorNetoOf,
            $Oferta_Personalizada->TotalAhorro,
            $Oferta_Personalizada->ReduccionAnual,
            $Oferta_Personalizada->ValorMesPromedio,
            $Oferta_Personalizada->AhorroMensualPromedio
        );

        $Respuesta_OfertaP = $this->OfertaRepository->RegistrarOfertaPersonalizada($Datos_OfertaP);

        if ($Respuesta_OfertaP !== true) {
            return $this->respondWithData(["ok"=> false, "error"=>$Respuesta_OfertaP]);
        }

        $Notas = $Oferta_V->Notas;
        $Aclaraciones = $Oferta_V->Aclaraciones;

        if (!empty($Notas)) {
            foreach ($Notas as $ItemNotas) {
                $RespuestaNotas = $this->OfertaRepository->RegistrarNotas($Id_Oferta,$ItemNotas);
                if ($RespuestaNotas !== true) {
                    return $this->respondWithData(["ok"=> false, "error"=>$RespuestaNotas]);
                }
            }
        }

        if (!empty($Aclaraciones)) {
            foreach ($Aclaraciones as $ItemAclaraciones) {
                $RespuestaAclaraciones = $this->OfertaRepository->RegistrarAclaraciones($Id_Oferta,$ItemAclaraciones);
                if ($RespuestaAclaraciones !== true) {
                    return $this->respondWithData(["ok"=> false, "error"=>$RespuestaAclaraciones]);
                }
            }
        }

        return $this->respondWithData(["ok"=> true]);
    }
}
