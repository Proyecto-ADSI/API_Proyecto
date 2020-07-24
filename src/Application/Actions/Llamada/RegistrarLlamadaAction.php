<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Cliente\RegistrarCliente;
use App\Application\Actions\Configuracion\MetodosSistema;
use App\Application\Actions\General\Correo_OfertaAction;
use App\Application\Actions\General\HTMLOferta;
use App\Application\Actions\Notificaciones\RegistrarNotificaciones;
use App\Application\Actions\General\PDF_OfertaAction;
use App\Domain\Atencion_Telefonica\AtencionTelefonica;
use App\Domain\Cita\Cita;
use App\Domain\DBL\DBL;
use App\Domain\Linea\Linea;
use App\Domain\Llamada\Llamada;
use App\Domain\Llamada_Programada\Llamada_Programada;
use App\Domain\Notificacion\Notificacion;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Domain\Oferta\Oferta;
use App\Domain\Oferta\Oferta_P;
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
                $campos->Id_Operador_Oferta
            );
            $res = $this->Atencion_TelefonicaRepository->RegistrarAtencionTelefonica($AT);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_AT = $res;
            $Oferta = new Oferta(
                NULL,
                $Id_AT,
                NULL,
                NULL,
                $campos->Nombre_Cliente,
                $campos->Mensaje_Superior,
                $campos->Tipo_Oferta,
                NULL,
                NULL,
                $campos->Estado_Oferta,
            );
            $res = $this->Oferta_Repository->RegistrarOferta($Oferta);
            if (!is_numeric($res)) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            $Id_Oferta = $res;

            // Registro de accion
            $Mensaje = "Se registra la oferta";
            $res = $this->Oferta_Repository->RegistrarAccionOferta($Id_Usuario,$Id_Oferta,1,$Mensaje);
            if ($res != true) {
                return $this->respondWithData(["ok" => false, "error" => $res]);
            }
            
            // Se valida el tipo de oferta que se debe registrar
            if ($campos->Tipo_Oferta == 1) {
                //  OFERTA ESTÁNDAR
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
                        $res = $this->Oferta_Repository->RegistrarPropuestas((int) $lineaItem->cantidadLineasOferta, $Id_Linea);
                        if (!is_numeric($res)) {
                            return $this->respondWithData(["ok" => false, "error" => $res]);
                        }
                        $Id_Propuesta = $res;

                        // 2) Registrar  oferta estandar
                        $res = $this->Oferta_Repository->RegistrarOfertaEstandar($Id_Oferta, $Id_Propuesta);
                        if ($res !== true) {
                            return $this->respondWithData(["ok" => false, "error" => $res]);
                        }
                    }
                }
            } else {
                //  OFERTA PERSONALIZADA:

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
                $Id_CorporativoAnterior = $this->Oferta_Repository->RegistrarDBLAnterior($Id_DBL);
                $Id_CorporativoActual = $this->Oferta_Repository->RegistrarDBLActual($Id_DBL_Oferta);
                // 1.5) Registrar  oferta personalizada
                $Ajuste_Financiero =  $campos->Ajuste_Financiero;
                $Oferta_P = new Oferta_P(
                    NULL,
                    $Id_Oferta,
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
                $respuesta = $this->Oferta_Repository->RegistrarOfertaPersonalizada($Oferta_P);
                if ($respuesta !== true) {
                    return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                }
            }

            // Registro de textos
            $arrayAclaraciones = $campos->Aclaraciones;
            if (!empty($arrayAclaraciones)) {
                foreach ($arrayAclaraciones as $item) {
                    $respuesta = $this->Oferta_Repository->RegistrarAclaraciones($Id_Oferta, $item);
                    if ($respuesta !== true) {
                        return $this->respondWithData(["ok" => false, "error" => $respuesta]);
                    }
                }
            }
            $arrayNotas = $campos->Notas;
            if (!empty($arrayNotas)) {
                foreach ($arrayNotas as $item) {
                    $respuesta = $this->Oferta_Repository->RegistrarNotas($Id_Oferta, $item);
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
                $Id_Oferta
            );
            // Roles a los que desea notificar.
            $roles = array(1, 2);
            $RegistroNotificacion->RegistrarNotificacion($notificacion, $roles);



            $HTMLOferta = new HTMLOferta();
            $html = "";
            if ($campos->Tipo_Oferta == 1) {
                // Generar HTML  Oferta Estándar
                $html = $HTMLOferta->GenerarHTMLOferta(
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
                // Generar HTML  Oferta Personalizada
                $html = $HTMLOferta->GenerarHTMLOferta(
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
            $PDF_OfertaAction = new PDF_OfertaAction();
            $Correo_Oferta = new Correo_OfertaAction();
            switch ($campos->Medio_Envio) {
                case 1:
                    // Enviar correo
                    if ($campos->Tipo_Oferta == 1) {
                        $respuesta = $Correo_Oferta->EnviarCorreoOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorOferta['Correo_Operador'],
                            $infoOperadorOferta['Contrasena_Operador'],
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
                        $respuesta =  $Correo_Oferta->EnviarCorreoOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorOferta['Correo_Operador'],
                            $infoOperadorOferta['Contrasena_Operador'],
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
                    $nombre_archivo = $PDF_OfertaAction->GenerarPDFOferta($html);
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
                        $respuesta = $Correo_Oferta->EnviarCorreoOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorOferta['Correo_Operador'],
                            $infoOperadorOferta['Contrasena_Operador'],
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
                        $respuesta =  $Correo_Oferta->EnviarCorreoOferta(
                            $campos->Correo,
                            $campos->Nombre_Cliente,
                            $campos->Tipo_Oferta,
                            $infoOperadorOferta['Nombre_Operador'],
                            $infoOperadorOferta['Imagen_Operador'],
                            $infoOperadorOferta['Color'],
                            $infoOperadorOferta['Correo_Operador'],
                            $infoOperadorOferta['Contrasena_Operador'],
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
                    $nombre_archivo = $PDF_OfertaAction->GenerarPDFOferta($html);
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
