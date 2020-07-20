<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use Psr\Http\Message\ResponseInterface as Response;

class ListarVisitasAction extends CitaAction
{
  protected function action(): Response
  {

    $VisitasSinFin = $this->VisitasRepository->ListarVisitas();
    $TiempoFin = $this->VisitasRepository->ListarTiempoFin();
    $TiempoFinUnix = strtotime($TiempoFin['Duracion_Cita']);
    $horas = date("H", $TiempoFinUnix);
    $minutos = date("i", $TiempoFinUnix);
    $horas = (int) $horas;
    $minutos = (int) $minutos;
    $horasSeg = $horas * 3600;
    $minutosSeg = $minutos * 60;
    $segundos = $horasSeg + $minutosSeg;

    $visitasFechaFormateada = [];

    foreach ($VisitasSinFin as $visita) {

      $fechaFinUnix = strtotime("+ " . $segundos . "seconds", strtotime($visita['Fecha_Cita']));
      $fechaFin = date("Y-m-d H:i:s", $fechaFinUnix);
      $visita['Fecha_Fin_Cita'] =  $fechaFin;
      array_push($visitasFechaFormateada, $visita);
    }
    $Operadores = $this->VisitasRepository->ListarOperadoresVisitas();

    $ArrayVisitasSinFin = array(
      'Visitas' => $visitasFechaFormateada
    );

    $OperadoresCitas = array(
      'OperadoresCitas' => $Operadores
    );

    $Visitas = array_merge($ArrayVisitasSinFin, $OperadoresCitas);

    return $this->respondWithData($Visitas);
  }
}
