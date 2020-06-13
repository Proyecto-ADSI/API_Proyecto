<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;
  use Mpdf\Mpdf;

  class PDFCitasAction extends CitaAction
  {
   protected function action(): Response
   {
    $campos = $this->getFormData();

    $Html = "";
    //Ruta raiz (public)
    $RutaPublic = $_SERVER['DOCUMENT_ROOT'];
    // $HoyFecha = date("Y-m-d"); 
    // $HoyHora = date("Y-m-d");
    date_default_timezone_set("America/Bogota");

    $Fecha = date('H:i:A');
  
    $mpdf = new Mpdf();
    $RutaCss = __DIR__ . '\Recursos\style.css';
    $Css =  file_get_contents($RutaCss);

    foreach ($campos as $Usuario) {
      $Html=$Html.'<h1>'.$Usuario->Nombre.'</h1><br><h1>'.$Usuario->Apellidos.'</h1><br>';
    }

    $mpdf->WriteHTML($Css,1);
    $mpdf->WriteHTML($Html,2);
    
    // $NombreArchivo = '\ReporteCitas'.$campos->Id_Cita.'.pdf';
    $extension = "pdf";
    // $basename = bin2hex(random_bytes(8));
    $NombreArchivo = sprintf('%s.%0.8s', $Fecha, $extension);
   
    //Ruta donde se va a guardar el archivo
    $Ruta = $RutaPublic . '\Reportes\ReporteCita'.$NombreArchivo;

    $mpdf->Output($Ruta, 'F');

    $NombreArchivoFinal = "ReporteCita".$NombreArchivo;

    return $this->respondWithData($NombreArchivoFinal);
   }
  
  }
