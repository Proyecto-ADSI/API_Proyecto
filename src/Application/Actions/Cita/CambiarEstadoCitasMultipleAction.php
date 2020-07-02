<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

use App\Domain\Visitas\Visitas;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Cita\PDFCitasAction;

class CambiarEstadoCitasMultipleAction extends CitaAction
  {
   protected function action(): Response
   {  
      $campos = $this->getFormData();

      $DataEstados = null;
      $PdfCitaExterna = null;

      $Pdf = new PDFCitasAction(
        $this->logger,
        $this->ClienteRepository,
        $this->DBLRepository,
        $this->Plan_CorporativoRepository,
        $this->Doc_SoporteRepository,
        $this->BarriosVeredasRepository,
        $this->SubTipoRepository,
        $this->MunicipioRepository,
        $this->DepartamentoRepository,
        $this->PaisRepository,
        $this->LineaRepository,
        $this->CitaRepository,
        $this->VisitasRepository
      );
      
      
      foreach($campos as $Cita){

        $Id = (int) $Cita->Id_Cita;
        $Estado = $Cita->Estado;
        $TipoVisita =(int)$Cita->TipoVisita;
        $Id_Asesor_Externo = (int)$Cita->Id_Asesor_Externoo;

        $datos = new Visitas(
           NULL,
           $TipoVisita,
           $Id_Asesor_Externo,
           $Id,
           NULL,
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

        $PdfCitaExterna = $Pdf->GenerarPdf($campos);

        return $this->respondWithData($PdfCitaExterna);

      }
      else{

      return $this->respondWithData('Algo estuvo mal');
      
    }

  }
  }