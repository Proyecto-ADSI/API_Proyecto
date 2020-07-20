<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

use App\Domain\Visitas\Visitas;
use Psr\Http\Message\ResponseInterface as Response;


class AsignarCitasInterAction extends CitaAction
  {
   protected function action(): Response
   {  
      $campos = $this->getFormData();
      
      foreach($campos as $Cita){

        $Id = (int) $Cita->Id_Cita;
        $Estado = $Cita->Estado_Cita;
        $TipoVisita =(int)$Cita->TipoVisita;
        $Id_Asesor_Interno = (int)$Cita->Id_Asesor_Interno;
        $Id_Estado_Visita = (int)$Cita->Id_Estado_Visitaa;

        $datos = new Visitas(
           NULL,
           $TipoVisita,
           $Id_Asesor_Interno,
           $Id,
           NULL,
           $Id_Estado_Visita
        );

        if (is_numeric($Id) && is_numeric($Estado) && is_numeric($TipoVisita) && is_numeric($Id_Asesor_Interno)) {

           $this->CitaRepository->CambiarEstadoRC($Id,$Estado);

           $this->VisitasRepository->RegistrarVisitas($datos);

           return $this->respondWithData(["Ok"=> true]);
        }
        else{
          return $this->respondWithData('Algo estuvo mal');
        }
      }
      
  }
  }