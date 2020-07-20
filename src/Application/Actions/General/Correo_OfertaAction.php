<?php

declare(strict_types=1);

namespace App\Application\Actions\General;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Correo_OfertaAction
{
    public function EnviarCorreoOferta(
        string $Email_Cliente,
        string $Nombre_Cliente,
        int $Tipo_Oferta,
        string $Nombre_Operador_Oferta,
        string $Imagen_Operador_Oferta,
        string $Color_Operador_Oferta,
        string $Correo_Operador_Oferta,
        string $Contrasena_Operador_Oferta,
        ?string $Nombre_Operador_Cliente,
        ?string $Color_Operador_Cliente,
        ?array $arrayServiciosOE,
        ?array $arrayServiciosOP,
        ?object $AjusteFinanciero,
        ?int $Cantidad_Total_LineasOP,
        ?string $textoSuperior,
        ?array $arrayAclaraciones,
        array $arrayNotas,
        string $Nombre_Remitente
    ) {

        $contenidoDinamico = "";

        if ($Tipo_Oferta == 1) {
            $contador = 0;
            foreach ($arrayServiciosOE as $item) {
                $contador++;

                $minutosLDI = "";
                $paisesLDI = "";
                foreach ($item->minutosLDI as $pais) {
                    $paisesLDI = $paisesLDI . $pais . ", ";
                }
                $minutosLDI = $paisesLDI . "( " . $item->cantidadLDI . " min)";

                $serviciosIlimitados = "";
                foreach ($item->serviciosIlimitados as $servicioI) {
                    $serviciosIlimitados = $serviciosIlimitados . '
                        <span style="padding: 3px 10px;line-height: 13px;color: #ffffff;font-weight: 400;border-radius: 4px;font-size: 75%;background-color:' . $Color_Operador_Oferta . '; color:#fff;margin: 20px 5px;">
                        ' . $servicioI . '
                        </span>     
                    ';
                }
                $serviciosAdicionales = "";
                foreach ($item->serviciosAdicionales as $servicioA) {
                    $serviciosAdicionales = $serviciosAdicionales . '
                        <span style="padding: 3px 10px;line-height: 13px;color: #ffffff;font-weight: 400;border-radius: 4px;font-size: 75%;background-color:' . $Color_Operador_Oferta . '; color:#fff;margin: 20px 5px;">
                        ' . $servicioA . '
                        </span>     
                    ';
                }
                $Propuesta = '
                <tr>
                    <td style="padding: 0 5% 5%;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="border: 2px solid ' . $Color_Operador_Oferta . ';border-radius: 10px;padding-bottom: 10px;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p style="background:' . $Color_Operador_Oferta . ';border: 2px solid ' . $Color_Operador_Oferta . ';border-radius: 5px 5px 0 0;margin: 0;padding: .75rem 1.25rem;border-bottom: 1px solid rgba(0,0,0,.125);color: #fff;font-size: 1.5rem;font-weight: bold;text-align: center;">
                                            Propuesta ' . $contador . '
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:5% 5% 0 5%">
                                        <table cellspacing="0" cellpadding="10" border="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="color: #fff; background-color:' . $Color_Operador_Oferta . ';">
                                                        Item
                                                    </th>
                                                    <th style="color: #fff; background-color:' . $Color_Operador_Oferta . ';">
                                                        Cantidad
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="background:#f2f4f8;">
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Cantidad mínima de líneas
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        ' . $item->cantidadLineas .  '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Minutos a todo destino
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                    ' . $item->minutos .  '
                                                    </td>
                                                </tr>
                                                <tr style="background:#f2f4f8;">
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Datos
                                                    </td>
                                                    <td
                                                        style="border-top:1px solid #f3f1f1; color: #ef5350; font-size: 25px; font-weight: 1000;">
                                                        ' . $item->navegacion .  ' GB
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Minutos LDI
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        ' . $minutosLDI . '
                                                    </td>
                                                </tr>
                                                <tr style="background:#f2f4f8;">
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        SMS todo destino
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        ' . $item->mensajes .  '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Servicios ilimitados
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        ' . $serviciosIlimitados . '
                                                    </td>
                                                </tr>
                                                <tr style="background:#f2f4f8;">
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Servicios adicionales
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        ' . $serviciosAdicionales . '
                                                    </td>
                                                </tr>
                                                <tr style="font-size: 25px;color: #ef5350 ; font-weight: bold;">
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        Cargo básico por línea
                                                    </td>
                                                    <td style="border-top:1px solid #f3f1f1;">
                                                        <b>$</b>
                                                        <span style="float: right;">
                                                            ' . $item->cargoBasicoMensual .  '
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                ';
                $contenidoDinamico = $contenidoDinamico . $Propuesta;
            }
        } else {
            $filas = "";
            foreach ($arrayServiciosOP as $item) {
                $filas = $filas . '
                <tr>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">' . $item->cantidadLineas . '</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">' . $item->navegacion1 . ' GB</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">' . $item->minutos1 . '</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">$ ' . $item->cargoBasico1 . '</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">' . $item->navegacion2 . ' GB</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">' . $item->minutos2 . '</td>
                    <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">$' . $item->cargoBasico2 . '</td>
                </tr>
                ';
            }

            $contenidoDinamico = '
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 2px solid #495057;border-radius: 10px;padding-bottom: 20px;margin-bottom: 30px;">
                        <tbody>
                            <tr>
                                <td>
                                    <p style="background:#495057;border: 2px solid #495057;border-radius: 5px 5px 0 0;margin: 0;padding: .75rem 1.25rem;border-bottom: 1px solid rgba(0,0,0,.125);color: #fff;font-size: 1.5rem;font-weight: bold;text-align: center;">
                                        Comparativo de servicios móviles
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:5px 2%">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span
                                                        style="color: #455a64;line-height: 40px;font-size: 36px;font-weight: bold;">
                                                        ' . $Nombre_Operador_Cliente . '
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <span
                                                        style="color: #455a64;line-height: 40px;font-size: 36px;font-weight: bold;">
                                                        VS
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <span
                                                        style="color: #455a64;line-height: 40px;font-size: 36px;font-weight: bold;">
                                                        ' . $Nombre_Operador_Oferta . '
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 5px;">
                                    <table width="100%" style="border-collapse: collapse;">
                                        <thead style="font-weight: 500;">
                                            <tr>
                                                <th
                                                    style="background-color:' . $Color_Operador_Cliente . ';color:#fff;padding: 0.75rem; border-color: #f3f1f1;">
                                                    Líneas
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Cliente . '; color:#fff;padding: 0.75rem; border-color: #f3f1f1;">
                                                    Datos
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Cliente . ';color:#fff;padding: 0.75rem;  border-color: #f3f1f1;">
                                                    Minutos
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Cliente . '; color:#fff; padding: 0.75rem; border-color: #f3f1f1;">
                                                    Cargo
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Oferta . '; color:#fff;padding: 0.75rem;  border-color: #f3f1f1;">
                                                    Datos
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Oferta . '; color:#fff;padding: 0.75rem;  border-color: #f3f1f1;">
                                                    Minutos
                                                </th>
                                                <th
                                                    style="background-color:' . $Color_Operador_Oferta . '; color:#fff;padding: 0.75rem;  border-color: #f3f1f1;">
                                                    Cargo
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $filas . '
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="line-height: 18px;font-size: 16px;font-weight: 700;color: #455a64;border-top:1px solid #f3f1f1;
                                                ">
                                                    Total: ' . $Cantidad_Total_LineasOP . '
                                                </td>
                                                <td colspan="2" style="padding: 0.75rem; border-top:1px solid #f3f1f1;font-weight: 700;line-height: 18px;
                                                font-size: 16px;color: #455a64;">
                                                    Cargo básico neto:
                                                </td>
                                                <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">
                                                    $ ' . $AjusteFinanciero->Basico_Neto_Operador1 . '
                                                </td>
                                                <td colspan="2" style="padding: 0.75rem; border-top:1px solid #f3f1f1;font-weight: 700;line-height: 18px;
                                                font-size: 16px;color: #455a64;">
                                                    Cargo básico neto:
                                                </td>
                                                <td style="padding: 0.75rem; border-top:1px solid #f3f1f1;">
                                                    $ ' . $AjusteFinanciero->Basico_Neto_Operador2 . '
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:0 5%">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%"
                        style="border: 2px solid ' . $Color_Operador_Oferta . ';border-radius: 10px;padding-bottom: 20px;">
                        <tbody>
                            <tr>
                                <td>
                                    <p style="
                                        background:' . $Color_Operador_Oferta . ';
                                        border: 2px solid ' . $Color_Operador_Oferta . ';
                                        border-radius: 5px 5px 0 0;
                                        margin: 0;
                                        padding: .75rem 1.25rem;
                                        border-bottom: 1px solid rgba(0,0,0,.125);
                                        color: #fff;
                                        font-size: 1.5rem;
                                        font-weight: bold;
                                        text-align: center;
                                        ">
                                        Propuesta ajustada a recursos
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:5%">
                                    <table cellspacing="0" cellpadding="10" border="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="color: #ffF; background-color:' . $Color_Operador_Oferta . ';">
                                                    Flujo financiero
                                                </th>
                                                <th style="color: #ffF; background-color:' . $Color_Operador_Oferta . '; ">
                                                    Concepto
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background:#f2f4f8;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Total facturación en ' . $Nombre_Operador_Cliente . '</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Valor_Neto_Operador1 . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Cargo básico neto en ' . $Nombre_Operador_Oferta . '</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Valor_Bruto_Operador2 . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="background:#f2f4f8;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Bonos de activación</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Bono_Activacion . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Cancelación cláusula</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Clausula . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="background:#f2f4f8;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Total facturación en ' . $Nombre_Operador_Oferta . '</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Total_Ahorro . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Reducción anual</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Reduccion_Anual . ' <b>%</b>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="background:#f2f4f8;font-size: 20px;color: #ef5350 ; font-weight: bold;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Total ahorro
                                                </td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Total_Ahorro . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="font-size: 25px;color: #ef5350 ; font-weight: bold;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Valor mes promedio
                                                </td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Valor_Mes_Promedio . '
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="background:#f2f4f8;">
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    Ahorro mensual promedio</td>
                                                <td style="border-top:1px solid #f3f1f1;">
                                                    <b>$</b>
                                                    <span style="float: right;">
                                                        ' . $AjusteFinanciero->Ahorro_Mensual_Promedio . '
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            ';
        }

        $aclaraciones = "";
        if (!empty($arrayAclaraciones)) {
            foreach ($arrayAclaraciones as $aclaracion) {
                $aclaraciones = $aclaraciones . '
                    <li dir="ltr">' . $aclaracion . '</li>
                ';
            }
        }
        $notas = "";
        foreach ($arrayNotas as $nota) {
            $notas = $notas . '
                <li dir="ltr">' . $nota . '</li>
            ';
        }

        $html = '
            <table style="max-width:768px;color: #67757c; font-weight: 300; font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                    <tr>
                        <td>
                            <table style="max-width:670px;border:solid 1px #dcdcdc" width="100%" cellspacing="0" cellpadding="0"
                                border="0" align="center">
                                <tbody>
                                    <!-- Header -->
                                    <tr>
                                        <td style="background-image: url(http://localhost:8081/Images/Otras/HeaderCorreo.png);
                                            background-size: cover; text-align:center">
                                            <table style="height: 100px;float: right;" width="30%">
                                                <tbody>
                                                    <tr>
                                                        <td style="max-width: 50%; min-width: 50%; padding-bottom: 25px;">
                                                            <img src="http://localhost:8081/Images/Usuarios/' . $Imagen_Operador_Oferta . '"
                                                                width="50" alt="" tabindex="0">
                                                        </td>
                                                        <td style="max-width: 50%;min-width: 50%;padding-bottom: 25px;color: ' . $Color_Operador_Oferta . ';text-align: left;font-size: 20px;font-weight: 1000;">
                                                            ' . $Nombre_Operador_Oferta . '
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0px 10% 0px">
                                            <table style="max-width:570px;font-size:15px;line-height:1.3;text-align:left"
                                                width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding:0px 0px 20px" width="100%">
                                                            <p dir="ltr">Hola, ' . $Nombre_Cliente . '</p>
                                                            <p dir="ltr">
                                                                ' . $textoSuperior . '
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0px 2% 0px 2%">
                                            <table width="100%">
                                                <tbody>
                                                    ' . $contenidoDinamico . '
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 5%" width="100%">
                                            <div style="    border-radius: 80px;background-color: #a82d2d;color: #fff;padding: 20px 50px;margin-left: 5%;">
                                                <h2 style="font-weight: bold;">Aclaraciones:</h2>
                                                <ul>
                                                    ' . $aclaraciones . '
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="font-size:15px;">
                                        <td style="padding: 10px 10%" width="100%">
                                            <h2 style="font-weight: bold;">Notas:</h2>
                                            <ul>
                                                ' . $notas . '
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr style="font-size:15px;">
                                        <td style="padding: 10px 10%" width="100%">
                                            <p dir="ltr">
                                                Antonio, en caso de que desee iniciar plan corporativo, los
                                                documentos que se necesitan para continuar con el proceso son:
                                            </p>
                                            <ul>
                                                <li dir="ltr">Cámara de comercio.</li>
                                                <li dir="ltr">
                                                    Foto por lado y lado de la cédula del representante legal de
                                                    la empresa.
                                                </li>
                                                <li dir="ltr">
                                                    Un soporte de ingresos que puede ser solo uno de estas
                                                    opciones:
                                                    <ul>
                                                        <li>Declaración de renta del año anterior</li>
                                                        <li>Extractos bancarios de los 2 últimos meses.</li>
                                                        <li>Factura del operador actual (solo si cuenta con plan
                                                            corporativo)</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr style="font-size:15px;">
                                        <td style="padding: 10px 10%" width="100%">
                                            <p dir="ltr">
                                                Puede enviar los documentos a este correo o si tiene dudas y
                                                desea asesoría puede ingresar al botón de contactar vía WhatsApp
                                            </p>
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <img src="http://localhost:8081/Images/Usuarios/' . $Imagen_Operador_Oferta . '"
                                                                width="100">
                                                        </td>
                                                        <td style="line-height: 0.4;">
                                                            <p dir="ltr">Ejecutivo comercial</p>
                                                            <p dir="ltr">Nombre asesor</p>
                                                            <p dir="ltr">WhatsApp: 3123445678</p>
                                                        </td>
                                                        <td>
                                                            <a style="cursor: pointer;padding: 7px 12px;color: #fff;background: #be3434;text-decoration: none;border: 1px solid transparent;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;font-size: 1rem;line-height: 1.5;border-radius: .25rem;"
                                                                href="#">
                                                                Contactar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="font-size:15px;">
                                        <td style=" padding: 10px;line-height: 0.4;">
                                            <p dir="ltr">Cordialmente,</p>
                                            <p dir="ltr">Ejecutivo comercial,</p>
                                            <p dir="ltr">' . $Nombre_Remitente . '</p>
                                        </td>
                                    </tr>
                                    <!-- Footer -->
                                    <tr>
                                        <td>
                                            <table
                                                style="max-width:768px;font-family:Lucida Sans Unicode,Lucida Grande,sans-serif"
                                                width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:100%;max-width:251px;display:inline-block;">
                                                            <img src="http://localhost:8081/Images/Otras/FooterCorreo.png"
                                                                alt="Footer" style="max-width:251px;width:100%">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>    
            </table>
        ';

        // Enviar correo de validación email.
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $Correo_Operador_Oferta;                // SMTP usuario
            $mail->Password   = $Contrasena_Operador_Oferta;            // SMTP contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Correo 
            $mail->setFrom($Correo_Operador_Oferta, $Nombre_Operador_Oferta);       //Correo que envía el mensaje
            $mail->addAddress($Email_Cliente, $Nombre_Cliente);                     // Correo que recibe el mensaje

            // Contenido
            $mail->isHTML(true);                                                    // Set email format to HTML
            $mail->Subject = 'Oferta corporativo';
            $mail->Body = $html;

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return ["ok" => false, "Error" => "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}"];
        }
    }
}
