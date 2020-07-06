<?php

declare(strict_types=1);

namespace App\Application\Actions\General;

class HTMLPreOferta
{
    public function GenerarHTMLPre_Oferta(
        int $Tipo_Oferta,
        string $Nombre_Operador_Oferta,
        string $Imagen_Operador_Oferta,
        string $Color_Operador_Oferta,
        ?string $Nombre_Operador_Cliente,
        ?string $Color_Operador_Cliente,
        string $Nombre_Cliente,
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
            $contenidoPropuestas = "";
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
                        <span class="text-center labelItem" style="background-color:' . $Color_Operador_Oferta . ';">' . $servicioI . '</span>
                    ';
                }
                $serviciosAdicionales = "";
                foreach ($item->serviciosAdicionales as $servicioA) {
                    $serviciosAdicionales = $serviciosAdicionales . '
                        <span class="text-center labelItem" style="background-color:' . $Color_Operador_Oferta . ';">' . $servicioA . '</span>
                    ';
                }
                $Propuesta = '
                    <div class="col-md-6 colPropuesta">
                        <div class="card cardPropuesta2" style="border:' . $Color_Operador_Oferta . ' 2px solid; border-radius: 10px;">
                            <div class="card-header" style="background-color:' . $Color_Operador_Oferta . '; color:#fff">
                                <h4 class="tituloPropuesta">Propuesta ' . $contador . '</h4>
                            </div>
                            <div class="card-body">
                                <table id="TablaPropuesta" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="colum1Titulo" style="background-color:' . $Color_Operador_Oferta . '; color:#fff">Item</th>
                                            <th style="background-color:' . $Color_Operador_Oferta . '; color:#fff">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fila1">
                                            <td class="columna1">Cantidad mínima de líneas</td>
                                            <td class="columna2">' . $item->cantidadLineas .  '</td>
                                        </tr>
                                        <tr class="fila2">
                                            <td class="columna1"> Minutos a todo destino</td>
                                            <td class="columna2">  ' . $item->minutos .  '</td>
                                        </tr>
                                        <tr class="fila1">
                                            <td class="columna1">Datos</td>
                                            <td class="columna2">
                                                <h3 class="text-danger font-weight-bold text-uppercase">
                                                    ' . $item->navegacion .  ' GB
                                                </h3>
                                            </td>
                                        </tr>
                                        <tr class="fila2">
                                            <td class="columna1"> Minutos LDI</td>
                                            <td class="columna2"> ' . $minutosLDI . '</td>
                                        </tr>
                                        <tr class="fila1">
                                            <td class="columna1"> SMS todo destino</td>
                                            <td class="columna2"> ' . $item->mensajes .  '</td>
                                        </tr>
                                        <tr class="fila2">
                                            <td class="columna1">Servicios ilimitados</td>
                                            <td class="columna2">' . $serviciosIlimitados . '</td>
                                        </tr>
                                        <tr class="fila1">
                                            <td class="columna1"> Servicios adicionales</td>
                                            <td class="columna2">' . $serviciosAdicionales . '</td>
                                        </tr>
                                        <tr class="fila2">
                                            <td class="columna1">Cargo básico por línea</td>
                                            <td class="columna2">
                                                <h3 class="text-danger font-weight-bold text-uppercase">
                                                <i class="fa">&#xf155</i> ' . $item->cargoBasicoMensual .  '
                                                </h3>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                ';
                $contenidoPropuestas = $contenidoPropuestas . $Propuesta;
            }
            $contenidoDinamico = '
                <div id="contenidoPropuestas" class="row cardPropuesta">' . $contenidoPropuestas . '</div>
            ';
        } else {
            $filas = "";
            foreach ($arrayServiciosOP as $item) {
                $filas = $filas . '
                <tr>
                    <td>' . $item->cantidadLineas . '</td>
                    <td>' . $item->navegacion1 . ' GB</td>
                    <td>' . $item->minutos1 . '</td>
                    <td><i class="fa">&#xf155</i> ' . $item->cargoBasico1 . '</td>
                    <td>' . $item->navegacion2 . ' GB</td>
                    <td>' . $item->minutos2 . '</td>
                    <td><i class="fa">&#xf155</i> ' . $item->cargoBasico2 . '</td>
                </tr>
                ';
            }

            $contenidoDinamico = '
                <div class="row">
                    <div class="col-md-12">
                        <div class="card cardComparativo">
                            <div class="card-header titulo_comparativo">
                                Comparativo de servicios móviles
                            </div>
                            <div class="card-body">
                                <div class="textHeaderComparativo">
                                    <span class="txtHeader txtHeader1">
                                        ' . $Nombre_Operador_Cliente . '
                                    </span>
                                    <span class="txtHeader txtHeader1">
                                        VS
                                    </span>
                                    <span class="txtHeader txtHeader2">
                                        ' . $Nombre_Operador_Oferta . '
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color:' . $Color_Operador_Cliente . '; color:#fff">Líneas</th>
                                                        <th style="background-color:' . $Color_Operador_Cliente . '; color:#fff">Datos</th>
                                                        <th style="background-color:' . $Color_Operador_Cliente . '; color:#fff">Minutos</th>
                                                        <th style="background-color:' . $Color_Operador_Cliente . '; color:#fff">Cargo básico</th>
                                                        <th style="background-color:' . $Color_Operador_Oferta . '; color:#fff">Datos</th>
                                                        <th style="background-color:' . $Color_Operador_Oferta . '; color:#fff">Minutos</th>
                                                        <th style="background-color:' . $Color_Operador_Oferta . '; color:#fff">Cargo básico</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ' . $filas . '
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>
                                                            <h5 class="box-title">Total: ' . $Cantidad_Total_LineasOP . '</h5>
                                                        </td>
                                                        <td colspan="2">
                                                            <h5 class="font-weight-bold">Cargo básico neto:</h5>
                                                        </td>
                                                        <td><i class="fa">&#xf155</i> ' . $AjusteFinanciero->Basico_Neto_Operador1 . '</td>
                                                        <td colspan="2">
                                                            <h5 class="font-weight-bold"> Cargo básico neto:</h5>
                                                        </td>
                                                        <td><i class="fa">&#xf155</i> ' . $AjusteFinanciero->Basico_Neto_Operador2 . '</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row cardAjuste">
                    <div class="col-md-10 colAjuste">
                        <div class="card cardAjuste"style="border:' . $Color_Operador_Oferta . ' 2px solid; border-radius: 10px;">
                            <div class="card-header titulo_ajuste" style="background-color:' . $Color_Operador_Oferta . ';">
                                Propuesta ajustada a recursos
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-white" style="background-color:' . $Color_Operador_Oferta . '">
                                                            Flujo financiero
                                                        </th>
                                                        <th class="text-center text-white" style="background-color:' . $Color_Operador_Oferta . '">
                                                            Concepto
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Total facturación en ' . $Nombre_Operador_Cliente . '</td>
                                                        <td>
                                                            <i class="fa">&#xf155</i>
                                                            <span class="float-right">' . $AjusteFinanciero->Valor_Neto_Operador1 . '</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="fila2">
                                                        <td>Cargo básico neto en ' . $Nombre_Operador_Oferta . '</td>
                                                        <td>
                                                            <i class="fa">&#xf155</i>
                                                            <span class="float-right">' . $AjusteFinanciero->Valor_Bruto_Operador2 . '</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bonos de activación</td>
                                                        <td>
                                                            <i class="fa">&#xf155</i>
                                                            <span class="float-right">' . $AjusteFinanciero->Bono_Activacion . '</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="fila2">
                                                        <td>Cancelación cláusula</td>
                                                        <td>
                                                            <i class="fa">&#xf155</i>
                                                            <span class="float-right">' . $AjusteFinanciero->Clausula . '</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total facturación en ' . $Nombre_Operador_Oferta . '</td>
                                                        <td>
                                                            <i class="fa">&#xf155</i>
                                                            <span class="float-right">' . $AjusteFinanciero->Total_Ahorro . '</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="fila2">
                                                        <td>Reducción anual</td>
                                                        <td>
                                                            <span class="float-right">
                                                            ' . $AjusteFinanciero->Reduccion_Anual . ' <i class="fa">&#xf295</i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-danger font-weight-bold"> Total ahorro </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="float-right text-danger font-weight-bold">
                                                                <i class="fa text-danger">&#xf155</i> ' . $AjusteFinanciero->Total_Ahorro . '
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr class="fila2">
                                                        <td>
                                                            <h3 class="text-danger font-weight-bold text-uppercase">
                                                                Valor mes promedio
                                                            </h3>
                                                        </td>
                                                        <td>
                                                            <h3
                                                                class="float-right text-danger font-weight-bold text-uppercase">
                                                                <i class="fa text-danger">&#xf155</i> ' . $AjusteFinanciero->Valor_Mes_Promedio . '
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ahorro mensual promedio</td>
                                                        <td>
                                                            <span class="float-right"> 
                                                                <i class="fa">&#xf155</i> ' . $AjusteFinanciero->Ahorro_Mensual_Promedio . '
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        $aclaraciones = "";
        if (!empty($arrayAclaraciones)) {
            foreach ($arrayAclaraciones as $aclaracion) {
                $aclaraciones = $aclaraciones . '
                    <li>' . $aclaracion . '</li>
                ';
            }
        }
        $notas = "";
        foreach ($arrayNotas as $aclaracion) {
            $notas = $notas . '
                <li>' . $aclaracion . '</li>
            ';
        }

        $Html = '
            <div class="row m-b-20">
                <div class="col-md-12 text-center font-weight-bold">
                    <h1 class="font-weight-bold">Hola, <span id="nombreCliente">' . $Nombre_Cliente . '</span></h1>
                    <h4>Esta es la oferta que tenemos actualmente:</h4>
                    <h4 id="textoSuperior">' . $textoSuperior . '</h4>
                </div>
            </div>
            <div id="ContenidoDinamico">
                ' . $contenidoDinamico . '
            </div>
            <div id="filaAclaraciones_Notas" class="row">
                <div id="columnaAclaraciones" class="col-md-6 colPadre">
                    <div class="sectionAclaraciones">
                        <h2 class="SubTituloOferta"> <i class="fa fa-warning"></i> Aclaraciones:</h2>
                        <ul id="listaAclaraciones">
                            ' . $aclaraciones . '
                        </ul>
                    </div>
                </div>
                <div id="columnaNotas" class="col-md-6">
                    <div class="sectionNotas">
                        <h2 class="SubTituloOferta"> <i class="fa fa-file-text"></i> Notas:</h2>
                        <ul id="listaNotasModal">
                            ' . $notas . '
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="sectionIndicaciones">
                        <h4 class="SubTituloOferta">
                            <span id="nombreCliente2">' . $Nombre_Cliente . '</span>, en caso de que desee iniciar plan corporativo,
                            los documentos que se necesitan para continuar con el proceso son:
                        </h4>
                        <ul>
                            <li>Cámara de comercio.</li>
                            <li>Foto por lado y lado de la cédula del representante legal de la empresa.</li>
                            <li>Un soporte de ingresos que puede ser solo uno de estas opciones:
                                <ul>
                                    <li>Declaración de renta del año anterior</li>
                                    <li>Extractos bancarios de los 2 últimos meses.</li>
                                    <li>Factura del operador actual (solo si cuenta con plan corporativo)</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="sectionContacto">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Puede enviar los documentos a este correo o si tiene dudas y desea asesoría puede contactarnos vía WhatsApp</p>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div align="left" style="width: 50%;float: left;">
                                <img src="' . $_SERVER['DOCUMENT_ROOT'] . '/Images/Usuarios/' . $Imagen_Operador_Oferta . '" style="max-width:150px;height:auto">
                            </div>
                            <div align="left" style="margin-top:50px; width: 50%;float: left;">
                                <h4>Ejecutivo comercial</h4>
                                <h4>Nombre asesor</h4>
                                <h4>WhatsApp: 3123445678</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Cordialmente,</h4>
                    <h4>Ejecutivo comercial,</h4>
                    <h4 id="nombreEmpleado">' . $Nombre_Remitente . '</h4>
                </div>
            </div>
        ';

        return $Html;
    }
}
