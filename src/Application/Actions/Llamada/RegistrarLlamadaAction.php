<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Cliente\RegistrarCliente;
use App\Application\Actions\Configuracion\MetodosSistema;
use App\Application\Actions\General\Correo_Pre_OfertaAction;
use App\Application\Actions\General\HTMLPreOferta;
use App\Application\Actions\Notificaciones\RegistrarNotificaciones;
use App\Application\Actions\General\PDF_Pre_OfertaAction;
use App\Domain\Atencion_Telefonica\AtencionTelefonica;
use App\Domain\Cita\Cita;
use App\Domain\DBL\DBL;
use App\Domain\Linea\Linea;
use App\Domain\Llamada\Llamada;
use App\Domain\Llamada_Programada\Llamada_Programada;
use App\Domain\Notificacion\Notificacion;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Domain\Pre_Oferta\PreOferta;
use App\Domain\Pre_Oferta\PreOferta_P;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarLlamadaAction extends LlamadaAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();
        $Id_Usuario = $campos->Id_Usuario;
        $llamada = new Llamada(
            null,
            $Id_Usuario,
            null,
            $campos->Persona_Responde,
            null,
            $campos->Duracion_Llamada,
            $campos->Info_Habeas_Data,
            $campos->Observacion,
            $campos->Tipo_Llamada,
            $campos->Id_Estado_Llamada
        );

        $objCliente = new RegistrarCliente(
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
            $this->Lineas_FijasRepository,
            $this->NotificacionRepository,
            $this->Notificaciones_UsuarioRepository,
            $this->AsignacionERepository,
            $this->usuarioRepository,
            $this->configuracionRepository
        );
        $Id_Cliente = null;
        if ($campos->Validacion_Cliente) {
            // Registrar Cliente
            $res = $objCliente->RegistrarClientes($campos);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_Cliente = $res;
        } else {
            $Id_Cliente = (int) $campos->Id_Cliente;
            if ($campos->Estado_Cliente !== 2) {
                // Inhabilitar cliente
                $this->ClienteRepository->CambiarEstadoCliente($Id_Cliente, 0);
            }
            // Eliminar lote asignado
            $this->AsignacionERepository->EliminarEmpresaAsignada($Id_Usuario, $Id_Cliente);
        }
        if ($campos->Validacion_DBL) {
            $objCliente->RegistrarDBL($campos, $Id_Cliente);
        }

        $llamada->__set("Id_Cliente", $Id_Cliente);
        $res = $this->LlamadaRepository->RegistrarLlamada($llamada);
        if (!is_numeric($res)) {
            return $this->respondWithData(["ok" => false, "error" => $res]);
        }

        $Id_Llamada = $res;

        $RegistroNotificacion = new RegistrarNotificaciones(
            $this->logger,
            $this->Notificaciones_UsuarioRepository,
            $this->NotificacionRepository
        );
        // Validar si se agenda cita
        if ($campos->Validacion_Cita) {
            $cita = new Cita(
                null,
                $Id_Llamada,
                $campos->Encargado_Cita,
                $campos->Celular,
                $campos->Representante_Legal,
                $campos->Fecha_Cita,
                $campos->Duracion_Verificacion,
                $campos->Direccion,
                $campos->Barrios_Veredas_Cita,
                $campos->Lugar_Referencia,
                $campos->Id_Operador_Cita,
                null,
                null,
                $campos->Id_Estado_Cita
            );

            $res = $this->CitaRepository->RegistrarCita($cita);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_Cita = $res;
            // Registro de notificaciones
            if ($campos->Id_Estado_Cita !== 1) {
                $infoOperador = $this->OperadorRepository->ObtenerDatosOperador((int) $campos->Id_Operador_Cita);
                // Registrar notificacion de cita registrada.
                $mensaje = "Cita agendada para " . $infoOperador['Nombre_Operador'] . ".";
                $notificacion = new Notificacion(
                    null,
                    $Id_Usuario,
                    null,
                    $mensaje,
                    4,
                    $Id_Cita
                );
                // Roles a los que desea notificar.
                $roles = array(1, 2);
                $RegistroNotificacion->RegistrarNotificacion($notificacion, $roles);
            }
            // Programar llamada sobre cita agendada.
            // 1 -> sin confirmar
            // 2 -> sin recordar
            if ($campos->Id_Estado_Cita == 1 || $campos->Id_Estado_Cita == 2) {

                $llamadaProgramada = new Llamada_Programada(
                    null,
                    null,
                    $Id_Cita,
                    null,
                    $campos->Fecha_Programada,
                    null
                );

                $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);
                if ($respuesta !== true) {
                    return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                }
            }
        } else if ($campos->Validacion_AT) {
            // se valida si se registra atención telefónica
            $AT = new AtencionTelefonica(
                NULL,
                $Id_Llamada,
                $campos->Medio_Envio,
                $campos->Tiempo_Post_Llamada,
                $campos->Id_Operador_Oferta,
                NULL
            );
            $res = $this->Atencion_TelefonicaRepository->RegistrarAtencionTelefonica($AT);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_AT = $res;
            $Pre_Oferta = new PreOferta(
                NULL,
                $Id_AT,
                NULL,
                NULL,
                $campos->Estado_Pre_Oferta,
                $campos->Nombre_Cliente,
                $campos->Mensaje_Superior,
                $campos->Tipo_Oferta
            );
            $res = $this->Pre_Oferta_Repository->RegistrarPreOferta($Pre_Oferta);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_Pre_Oferta = $res;
            // Se valida el tipo de oferta que se debe registrar
            if ($campos->Tipo_Oferta == 1) {
                // PRE OFERTA ESTÁNDAR
                // 1) Registrar servicios móviles - propuestas
                $arrayLineas = $campos->Oferta_Estandar_BD;
                if (!empty($arrayLineas)) {
                    foreach ($arrayLineas as $lineaItem) {
                        $linea = new Linea(
                            NULL,
                            NULL,
                            $lineaItem->minutos,
                            $lineaItem->navegacion,
                            $lineaItem->mensajes,
                            $lineaItem->serviciosIlimitados,
                            $lineaItem->minutosLDI,
                            $lineaItem->cantidadLDI,
                            $lineaItem->serviciosAdicionales,
                            $lineaItem->cargoBasicoMensual,
                            $lineaItem->grupo
                        );

                        // Registrar servicios móviles
                        $Id_Linea = $this->LineaRepository->RegistrarLinea($linea);
                        // Registrar propuestas
                        $res = $this->Pre_Oferta_Repository->RegistrarPropuestas((int) $lineaItem->cantidadLineasOferta, $Id_Linea);
                        if (!is_numeric($res)) {
                            return $this->respondWithData(["ok" => false, "error" => $res]);
                        }
                        $Id_Propuesta = $res;

                        // 2) Registrar pre oferta estandar
                        $res = $this->Pre_Oferta_Repository->RegistrarPreOfertaEstandar($Id_Pre_Oferta, $Id_Propuesta);
                        if ($res !== true) {
                            return $this->respondWithData(["ok" => false, "error" => $res]);
                        }
                    }
                }
            } else {
                // PRE OFERTA PERSONALIZADA:

                // 1) Registrar DBL OFERTADO
                // 1.1) Registrar plan corporativo
                $Plan_Corporativo = new Plan_Corporativo(
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL
                );
                $Id_Plan_Corporativo =  $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
                // 1.2) Registrar DBL
                $DBL = new DBL(
                    NULL,
                    $Id_Cliente,
                    $campos->Id_Operador_Oferta,
                    $Id_Plan_Corporativo,
                    $campos->Cantidad_Total_LineasOP,
                    $campos->Valor_Total_MensualOP,
                    NULL,
                    NULL,
                    2
                );

                $Id_DBL_Oferta  = $this->DBLRepository->RegistrarDBL($DBL);

                // 1.3) Registrar líneas DBL
                $arrayLineas = $campos->Oferta_Personalizada_BD;

                if (!empty($arrayLineas)) {
                    foreach ($arrayLineas as $lineaItem) {
                        $linea = new Linea(
                            NULL,
                            NULL,
                            $lineaItem->minutos,
                            $lineaItem->navegacion,
                            $lineaItem->mensajes,
                            $lineaItem->serviciosIlimitados,
                            $lineaItem->minutosLDI,
                            $lineaItem->cantidadLDI,
                            $lineaItem->serviciosAdicionales,
                            $lineaItem->cargoBasicoMensual,
                            $lineaItem->grupo
                        );

                        if (!empty($lineaItem->numero)) {
                            $linea->__set("Linea", $lineaItem->numero);
                        }

                        $Id_Linea = $this->LineaRepository->RegistrarLinea($linea);
                        $respuesta = $this->LineaRepository->RegistrarDetalleLinea($Id_Linea, $Id_DBL_Oferta);
                        if ($respuesta !== true) {
                            return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                        }
                    }
                }
                // 1.4) Registrar Corporativos para comparativo
                $Estado_DBL_Cliente = (int) $campos->Estado_DBL;
                $respuesta = $this->DBLRepository->ListarDBL($Id_Cliente, $Estado_DBL_Cliente);
                $Id_DBL = (int) $respuesta['Id_DBL'];
                $Id_CorporativoAnterior = $this->Pre_Oferta_Repository->RegistrarDBLAnterior($Id_DBL);
                $Id_CorporativoActual = $this->Pre_Oferta_Repository->RegistrarDBLActual($Id_DBL_Oferta);
                // 1.5) Registrar Pre oferta personalizada
                $Ajuste_Financiero =  $campos->Ajuste_Financiero;
                $Pre_Oferta_P = new PreOferta_P(
                    NULL,
                    $Id_Pre_Oferta,
                    $Id_CorporativoAnterior,
                    $Id_CorporativoActual,
                    $Ajuste_Financiero->Basico_Neto_Operador1,
                    $Ajuste_Financiero->Basico_Neto_Operador2,
                    $Ajuste_Financiero->Valor_Neto_Operador1,
                    $Ajuste_Financiero->Valor_Bruto_Operador2,
                    $Ajuste_Financiero->Bono_Activacion,
                    $Ajuste_Financiero->Valor_Neto_Operador2,
                    $Ajuste_Financiero->Total_Ahorro,
                    $Ajuste_Financiero->Reduccion_Anual,
                    $Ajuste_Financiero->Valor_Mes_Promedio,
                    $Ajuste_Financiero->Ahorro_Mensual_Promedio
                );
                $respuesta = $this->Pre_Oferta_Repository->RegistrarPreOfertaPersonalizada($Pre_Oferta_P);
                if ($respuesta !== true) {
                    return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                }
            }

            // Registro de textos
            $arrayAclaraciones = $campos->Aclaraciones;
            if (!empty($arrayAclaraciones)) {
                foreach ($arrayAclaraciones as $item) {
                    $respuesta = $this->Pre_Oferta_Repository->RegistrarAclaraciones($Id_Pre_Oferta, $item);
                    if ($respuesta !== true) {
                        return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                    }
                }
            }
            $arrayNotas = $campos->Notas;
            if (!empty($arrayNotas)) {
                foreach ($arrayNotas as $item) {
                    $respuesta = $this->Pre_Oferta_Repository->RegistrarNotas($Id_Pre_Oferta, $item);
                    if ($respuesta !== true) {
                        return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                    }
                }
            }

            $infoOperadorOferta = $this->OperadorRepository->ObtenerDatosOperador((int) $campos->Id_Operador_Oferta);
            $infoOperadorCliente = $this->OperadorRepository->ObtenerDatosOperador((int) $campos->Id_Operador);

            // Registrar notificacion de oferta registrada.
            $mensaje = "Oferta registrada para " . $infoOperadorOferta['Nombre_Operador'] . ".";
            $notificacion = new Notificacion(
                null,
                $Id_Usuario,
                null,
                $mensaje,
                7,
                $Id_Pre_Oferta
            );
            // Roles a los que desea notificar.
            $roles = array(1, 2);
            $RegistroNotificacion->RegistrarNotificacion($notificacion, $roles);



            $HTMLPreOferta = new HTMLPreOferta();
            $html = "";
            if ($campos->Tipo_Oferta == 1) {
                // Generar HTML Pre Oferta Estándar
                $html = $HTMLPreOferta->GenerarHTMLPre_Oferta(
                    $campos->Tipo_Oferta,
                    $infoOperadorOferta['Nombre_Operador'],
                    $infoOperadorOferta['Imagen_Operador'],
                    $infoOperadorOferta['Color'],
                    $infoOperadorCliente['Nombre_Operador'],
                    $infoOperadorCliente['Color'],
                    $campos->Nombre_Cliente,
                    $campos->Oferta_Estandar_PDF,
                    NULL,
                    NULL,
                    NULL,
                    $campos->Mensaje_Superior,
                    $campos->Aclaraciones,
                    $campos->Notas,
                    $campos->Nombre_Empleado
                );
            } else {
                // Generar HTML Pre Oferta Personalizada
                $html = $HTMLPreOferta->GenerarHTMLPre_Oferta(
                    $campos->Tipo_Oferta,
                    $infoOperadorOferta['Nombre_Operador'],
                    $infoOperadorOferta['Imagen_Operador'],
                    $infoOperadorOferta['Color'],
                    $infoOperadorCliente['Nombre_Operador'],
                    $infoOperadorCliente['Color'],
                    $campos->Nombre_Cliente,
                    NULL,
                    $campos->Oferta_Personalizada_PDF,
                    $campos->Ajuste_Financiero,
                    $campos->Cantidad_Total_LineasOP,
                    $campos->Mensaje_Superior,
                    $campos->Aclaraciones,
                    $campos->Notas,
                    $campos->Nombre_Empleado
                );
            }

            // Medio_Envio:
            // 1 -> Correo
            // 2 -> WhatsApp
            // 3-> Ambos
            $PDF_Pre_OfertaAction = new PDF_Pre_OfertaAction();
            $Correo_Pre_Oferta = new Correo_Pre_OfertaAction();
            switch ($campos->Medio_Envio) {
                case 1:
                    // Enviar correo
                    if ($campos->Tipo_Oferta == 1) {
                        $respuesta = $Correo_Pre_Oferta->EnviarCorreoPreOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorCliente['Nombre_Operador'],
                            $infoOperadorCliente['Color'],
                            $campos->Oferta_Estandar_PDF,
                            NULL,
                            NULL,
                            NULL,
                            $campos->Mensaje_Superior,
                            $campos->Aclaraciones,
                            $campos->Notas,
                            $campos->Nombre_Empleado
                        );
                    } else {
                        $respuesta =  $Correo_Pre_Oferta->EnviarCorreoPreOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorCliente['Nombre_Operador'],
                            $infoOperadorCliente['Color'],
                            NULL,
                            $campos->Oferta_Personalizada_PDF,
                            $campos->Ajuste_Financiero,
                            $campos->Cantidad_Total_LineasOP,
                            $campos->Mensaje_Superior,
                            $campos->Aclaraciones,
                            $campos->Notas,
                            $campos->Nombre_Empleado
                        );
                    }
                    if ($respuesta !== true) {
                        return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                    } else {
                        return $this->respondWithData(["ok" => true]);
                    }
                    break;
                case 2:
                    // Generar PDF
                    $nombre_archivo = $PDF_Pre_OfertaAction->GenerarPDFPre_Oferta($html);
                    $info =  [
                        "archivo" => $nombre_archivo,
                        "celular" => $campos->Celular,
                        "MensajeInicio" => "Mensaje por defecto negociación WhatsApp"
                    ];
                    return $this->respondWithData(["ok" => true, "Envio_WhatsApp" => true, "info" => $info]);
                    break;
                case 3:
                    // Enviar correo
                    if ($campos->Tipo_Oferta == 1) {
                        $respuesta = $Correo_Pre_Oferta->EnviarCorreoPreOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorCliente['Nombre_Operador'],
                            $infoOperadorCliente['Color'],
                            $campos->Oferta_Estandar_PDF,
                            NULL,
                            NULL,
                            NULL,
                            $campos->Mensaje_Superior,
                            $campos->Aclaraciones,
                            $campos->Notas,
                            $campos->Nombre_Empleado
                        );
                    } else {
                        $respuesta =  $Correo_Pre_Oferta->EnviarCorreoPreOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorCliente['Nombre_Operador'],
                            $infoOperadorCliente['Color'],
                            NULL,
                            $campos->Oferta_Personalizada_PDF,
                            $campos->Ajuste_Financiero,
                            $campos->Cantidad_Total_LineasOP,
                            $campos->Mensaje_Superior,
                            $campos->Aclaraciones,
                            $campos->Notas,
                            $campos->Nombre_Empleado
                        );
                    }
                    if ($respuesta !== true) {
                        return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                    }
                    // Generar PDF
                    $nombre_archivo = $PDF_Pre_OfertaAction->GenerarPDFPre_Oferta($html);
                    $info =  [
                        "archivo" => $nombre_archivo,
                        "celular" => $campos->Celular,
                        "MensajeInicio" => "Mensaje por defecto negociación WhatsApp"
                    ];
                    return $this->respondWithData(["ok" => true, "Envio_WhatsApp" => true, "info" => $info]);
                    break;
            }
        } else if ($campos->Id_Estado_Llamada == 2) {
            // Registrar llamada  programada.
            $llamadaProgramada = new Llamada_Programada(
                null,
                $Id_Llamada,
                null,
                null,
                $campos->Fecha_LP,
                null
            );
            $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);
            if ($respuesta !== true) {
                return $this->respondWithData(["ok" => false, "error" => $respuesta]);
            }
        } else {
            // Registrar evento para habilitar cliente válido
            if ($campos->Estado_Cliente !== 2) {
                $metodos = new MetodosSistema(
                    $this->logger,
                    $this->configuracionRepository,
                    $this->usuarioRepository,
                    $this->ClienteRepository,
                    $this->AsignacionERepository,
                );
                $metodos->CrearEventoHabilitar($Id_Cliente);
            }
        }
        return $this->respondWithData(["ok" => true]);
    }
}
