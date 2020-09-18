<?php

declare(strict_types=1);

  namespace App\Application\Actions\Cita;

  use Psr\Http\Message\ResponseInterface as Response;
  use Mpdf\Mpdf;

  abstract class PDFCitasAction extends CitaAction
  {
   protected function action(): Response
   {
    $campos = $this->getFormData();

    $Pdf =  $this->GenerarPdf($campos);

    return $this->respondWithData($Pdf);
   }

   public function GenerarPdf($campos){

    $Informacion = $campos->InformacionPDF;
     
    $Html = "";
    //Ruta raiz (public)
    $RutaPublic = $_SERVER['DOCUMENT_ROOT'];
  
    $mpdf = new Mpdf();
    $RutaCss = __DIR__ . '\Recursos\style.css';
    $Img = __DIR__ . '\Recursos\logo.png';
    $Css =  file_get_contents($RutaCss);

    foreach ($campos as $Citas) {
      $Html=$Html.'<body>
      <header class="clearfix">
        <div id="logo">
          <img src='.$Img.'>
        </div>
        <div id="company">
          <h2 class="name"></h2>
          <div>455 Foggy Heights, AZ 85004, US</div>
          <div>(602) 519-0450</div>
          <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
        </div>
      </header>
      <main>
        <div id="details" class="clearfix">
          <div id="client">
            <div class="to">INVOICE TO:</div>
            <h2 class="name">John Doe</h2>
            <div class="address">796 Silver Harbour, TX 79273, US</div>
            <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
          </div>
          <div id="invoice">
            <h1>INVOICE 3-2-1</h1>
            <div class="date">Date of Invoice: 01/06/2014</div>
            <div class="date">Due Date: 30/06/2014</div>
          </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th class="no">#</th>
              <th class="desc">DESCRIPTION</th>
              <th class="unit">UNIT PRICE</th>
              <th class="qty">QUANTITY</th>
              <th class="total">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="no">01</td>
              <td class="desc"><h3>Website Design</h3>Creating a recognizable design solution based on the companys existing visual identity</td>
              <td class="unit">$40.00</td>
              <td class="qty">30</td>
              <td class="total">$1,200.00</td>
            </tr>
            <tr>
              <td class="no">02</td>
              <td class="desc"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
              <td class="unit">$40.00</td>
              <td class="qty">80</td>
              <td class="total">$3,200.00</td>
            </tr>
            <tr>
              <td class="no">03</td>
              <td class="desc"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
              <td class="unit">$40.00</td>
              <td class="qty">20</td>
              <td class="total">$800.00</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td colspan="2">SUBTOTAL</td>
              <td>$5,200.00</td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td colspan="2">TAX 25%</td>
              <td>$1,300.00</td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td colspan="2">GRAND TOTAL</td>
              <td>$6,500.00</td>
            </tr>
          </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
        <div id="notices">
          <div>NOTICE:</div>
          <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
      </main>
      <footer>
        Invoice was created on a computer and is valid without the signature and seal.
      </footer>
      <div class="container">
  <div class="row">
    <div class="col-sm">
      One of three columns
    </div>
    <div class="col-sm">
      One of three columns
    </div>
    <div class="col-sm">
      One of three columns
    </div>
  </div>
</div>
    </body>
    ';
    }

    $mpdf->WriteHTML($Css,1);
    $mpdf->WriteHTML($Html,2);
    
    // $NombreArchivo = '\ReporteCitas'.$campos->Id_Cita.'.pdf';
    $extension = "pdf";
    $basename = bin2hex(random_bytes(8));
    $NombreArchivo = sprintf('%s.%0.8s', $basename, $extension);
   
    //Ruta donde se va a guardar el archivo
    $Ruta = $RutaPublic . '\Reportes\ReporteCita'.$NombreArchivo;

    $mpdf->Output($Ruta, 'F');

    $NombreArchivoFinal = "ReporteCita".$NombreArchivo;

    return $NombreArchivoFinal;
   }
  }
