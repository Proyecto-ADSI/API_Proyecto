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

      $Operadores = $this->VisitasRepository->ListarOperadoresVisitas();

      $ArrayVisitasSinFin = array(
        'VisitasSinFin' => $VisitasSinFin
       );

      $TiempoFinCitas = array(
        'TiempoFin' => $TiempoFin
      );

      $OperadoresCitas = array(
        'OperadoresCitas' => $Operadores
      );

      $Visitas = array_merge($ArrayVisitasSinFin,$OperadoresCitas,$TiempoFinCitas);

      return $this->respondWithData($Visitas);
      
   }
  }