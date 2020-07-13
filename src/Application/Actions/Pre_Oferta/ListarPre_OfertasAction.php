<?php

declare(strict_types=1);

namespace App\Application\Actions\Pre_Oferta;

use Psr\Http\Message\ResponseInterface as Response;

class ListarPre_OfertasAction extends Pre_OfertaAction
{
    protected function action(): Response
    {
        $infoPreOfertas = $this->Pre_OfertaRepository->ListarPreOfertas();
        $arrayRespuesta = [];
        foreach ($infoPreOfertas as $item) {
            if ($item['Id_AT'] != null) {
                $Id_AT = (int) $item['Id_AT'];
                $infoAT = $this->AtencionTelefonicaRepository->ObtenerInfoAtencionTelefonica($Id_AT);
                $info = array_merge($item, $infoAT);

                // Obtener info de servicios
                $Tipo_Pre_Oferta = (int) $item['Tipo_Pre_Oferta'];
                $Id_Pre_Oferta = (int) $item['Id_Pre_Oferta'];
                if ($Tipo_Pre_Oferta == 1) {
                    $res = $this->Pre_OfertaRepository->ObtenerPreOfertaEstandar($Id_Pre_Oferta);

                    // Obtener info de textos
                    $aclaraciones = $this->Pre_OfertaRepository->ObtenerAclaraciones($Id_Pre_Oferta);
                    $notas = $this->Pre_OfertaRepository->ObtenerNotas($Id_Pre_Oferta);
                    $infoPOE = [
                        "Oferta" => $res,
                        "Textos" => [
                            "Aclaraciones" => $aclaraciones,
                            "Notas" => $notas,
                        ]
                    ];
                    $info = array_merge($info, $infoPOE);
                    array_push($arrayRespuesta, $info);
                } else {
                    $res = $this->Pre_OfertaRepository->ObtenerPreOfertaPersonalizada($Id_Pre_Oferta);
                    $Id_Corp_Anterior = (int) $res['Id_Corporativo_Anterior'];
                    $Id_Corp_Actual = (int) $res['Id_Corporativo_Actual'];
                    $DBLCliente = $this->DBLRepository->ObtenerDBL($Id_Corp_Anterior);
                    $DBLOferta = $this->DBLRepository->ObtenerDBL($Id_Corp_Actual);
                    // Obtener info de textos
                    $aclaraciones = $this->Pre_OfertaRepository->ObtenerAclaraciones($Id_Pre_Oferta);
                    $notas = $this->Pre_OfertaRepository->ObtenerNotas($Id_Pre_Oferta);
                    $infoPOP = [
                        "Comparativo" => $res,
                        "DBLOferta" => $DBLOferta,
                        "DBLCliente" => $DBLCliente,
                        "Textos" => [
                            "Aclaraciones" => $aclaraciones,
                            "Notas" => $notas,
                        ]
                    ];
                    $info = array_merge($info, $infoPOP);
                    array_push($arrayRespuesta, $info);
                }
            } else {
                // $Id_Visita = (int) $item['Id_Visita'];
                // Esperando módulo de visitas por parte de mauricio.
            }
        }
        return $this->respondWithData($arrayRespuesta);
    }
}
