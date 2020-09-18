<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

use App\Domain\Visitas\Visitas;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Cita\PDFCitasAction;

class CambiarEstadoCitasMultipleAction extends PDFCitasAction
  {
   protected function action(): Response
   {  
      $campos = $this->getFormData();

      $DataEstados = null;
      $PdfCitaExterna = null;


      
      
      foreach($campos as $Cita){

        $Id = (int) $Cita->Id_Cita;
        $Estado = $Cita->Estado_Cita;
        $TipoVisita =(int)$Cita->TipoVisita;
        $Id_Asesor_Externo = (int)$Cita->Id_Asesor_Externoo;
        $Id_Estado_Visita = (int)$Cita->Id_Estado_Visitaa;

        $datos = new Visitas(
           NULL,
           $TipoVisita,
           $Id_Asesor_Externo,
           $Id,
           NULL,
           $Id_Estado_Visita
        );

        if (is_numeric($Id) && is_numeric($Estado) && is_numeric($TipoVisita) && is_numeric($Id_Asesor_Externo)) {

          $DataEstados = $this->CitaRepository->CambiarEstadoRC($Id,$Estado);

          $AsignarExternas = $this->VisitasRepository->RegistrarVisitas($datos);

        }
        else{
          return $this->respondWithData('Algo estuvo mal');
        }
      }
      
      if ($DataEstados && $AsignarExternas) {

        $PdfCitaExterna = $this->GenerarPdf($campos);

        return $this->respondWithData($PdfCitaExterna);

      }
      else{

      return $this->respondWithData('Algo estuvo mal');
      
    }

  }
  }