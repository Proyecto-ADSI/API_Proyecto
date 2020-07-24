<?php

declare(strict_types=1);

namespace App\Application\Actions\Oferta;

use Psr\Http\Message\ResponseInterface as Response;

class ListarOfertasAction extends OfertaAction
{
    protected function action(): Response
    {   
        $infoOfertas = [];
        $Id_Rol = (int) $this->resolveArg("Id_Rol"); 
        switch($Id_Rol){
            case 1:
                $infoOfertas = $this->OfertaRepository->ListarOfertas();
            break;
        }
        $arrayRespuesta = [];
        foreach ($infoOfertas as $item) {
            if ($item['Id_AT'] != null) {
                $Id_AT = (int) $item['Id_AT'];
                $infoAT = $this->OfertaRepository->ObtenerInfoOfertaAT($Id_AT);
                // Obtener info de servicios
                $Tipo_Oferta = (int) $item['Tipo_Oferta'];
                $Id_Oferta = (int) $item['Id_Oferta'];

                $acciones = $this->OfertaRepository->ListarAccionesOferta($Id_Oferta);
                $infoAcciones = [
                    "Acciones" => $acciones
                ];
                $info = array_merge($item, $infoAT,$infoAcciones);
                
                if ($Tipo_Oferta == 1) {
                    $res = $this->OfertaRepository->ObtenerOfertaEstandar($Id_Oferta);
                    // Obtener info de textos
                    $aclaraciones = $this->OfertaRepository->ObtenerAclaraciones($Id_Oferta);
                    $notas = $this->OfertaRepository->ObtenerNotas($Id_Oferta);
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
                    $res = $this->OfertaRepository->ObtenerOfertaPersonalizada($Id_Oferta);
                    $Id_DBL_Anterior = (int) $res['DBL_Anterior'];
                    $Id_DBL_Actual = (int) $res['DBL_Actual'];
                    $DBLCliente = $this->DBLRepository->ObtenerDBL($Id_DBL_Anterior);
                    $DBLOferta = $this->DBLRepository->ObtenerDBL($Id_DBL_Actual);
                    // Obtener info de textos
                    $aclaraciones = $this->OfertaRepository->ObtenerAclaraciones($Id_Oferta);
                    $notas = $this->OfertaRepository->ObtenerNotas($Id_Oferta);
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
