<?php

declare(strict_types=1);

namespace App\Application\Actions\General;

use Mpdf\Mpdf;

use Mpdf\Config;

class PDF_OfertaAction
{
    public function GenerarPDFOferta($Html)
    {
        $RutaPublic = $_SERVER['DOCUMENT_ROOT'];
        // $mpdf = new Mpdf();
        $defaultConfig = (new Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
            'fontDir' => array_merge($fontDirs, [
                $RutaPublic . '/Recursos/Fuentes',
            ]),
            'fontdata' => $fontData + [
                'fontawesome' => [
                    'R' => 'fontawesome-webfont.ttf',
                ]
            ]
        ]);

        $RutaCss1 = $RutaPublic . '\Recursos\bootstrap.css';
        $Css1 =  file_get_contents($RutaCss1);
        $RutaCss2 = $RutaPublic . '\Recursos\font-awesome.css';
        $Css2 =  file_get_contents($RutaCss2);
        $RutaCss3 = $RutaPublic . '\Recursos\plantillaCompleta.css';
        $Css3 =  file_get_contents($RutaCss3);
        $RutaCss4 = $RutaPublic . '\Recursos\stylePDF_Oferta.css';
        $Css4 =  file_get_contents($RutaCss4);

        $mpdf->WriteHTML($Css1, 1);
        $mpdf->WriteHTML($Css2, 1);
        $mpdf->WriteHTML($Css3, 1);
        $mpdf->WriteHTML($Css4, 1);
        $mpdf->WriteHTML($Html, 2);

        $extension = "pdf";
        $basename = bin2hex(random_bytes(8));
        $NombreArchivo = sprintf('%s.%0.8s', $basename, $extension);

        //Ruta donde se va a guardar el archivo
        $Ruta = $RutaPublic . '\Reportes\ReporteOferta_' . $NombreArchivo;

        $mpdf->Output($Ruta, 'F');

        $NombreArchivoFinal = "ReporteOferta_" . $NombreArchivo;

        return $NombreArchivoFinal;
    }
}
