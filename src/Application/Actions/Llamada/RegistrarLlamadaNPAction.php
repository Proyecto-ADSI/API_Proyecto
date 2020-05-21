<?php

declare (strict_types = 1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Cliente\RegistrarCliente;
use App\Application\Actions\Notificaciones\RegistrarNotificaciones;
use App\Domain\Cita\Cita;
use App\Domain\Llamada\Llamada;
use App\Domain\Llamada_Programada\Llamada_Programada;
use App\Domain\Notificacion\Notificacion;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarLlamadaNPAction extends LlamadaAction
{
    protected function action(): Response
    {
        try {
            $respuesta = null;

            $campos = $this->getFormData();

            $llamada = new Llamada(
                null,
                $campos->Id_Usuario,
                null,
                $campos->Persona_Responde,
                null,
                $campos->Duracion_Llamada,
                $campos->Info_Habeas_Data,
                $campos->Observacion,
                $campos->Tipo_Llamada,
                $campos->Id_Estado_Llamada
            );

            if ($campos->Validacion_Registro_Cliente) {
                // Registrar Cliente
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
                    $this->NotificacionRepository,
                    $this->Notificaciones_UsuarioRepository
                );

                $respuesta = $objCliente->RegistrarClientes($campos);

                if ($respuesta !== true) {
                    return $this->respondWithData(["error" => $respuesta]);
                }

                $infoCliente = $this->ClienteRepository->ConsultarUltimoRegistrado();
                $Id_Cliente = (int) $infoCliente['Id_Cliente'];
                $llamada->__set("Id_Cliente", $Id_Cliente);
            }

            $respuesta = $this->LlamadaRepository->RegistrarLlamada($llamada);

            if ($respuesta !== true) {
                return $this->respondWithData(["error" => $respuesta]);
            }

            $infoLlamada = $this->LlamadaRepository->ConsultarUltimaLlamada();
            $Id_Llamada = (int) $infoLlamada['Id_Llamada'];

            $CitaRegistrada = false;
            // Validar si se agenda cita
            if ($campos->Validacion_Cita) {

                $cita = new Cita(
                    null,
                    $Id_Llamada,
                    $campos->Encargado_Cita,
                    $campos->Ext_Tel_ContactoEC,
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

                $respuesta = $this->CitaRepository->RegistrarCita($cita);
                if ($respuesta !== true) {
                    return $this->respondWithData(["error" => $respuesta]);
                }

                if ($campos->Id_Estado_Cita == 2) {
                    $CitaRegistrada = true;
                }

                $infoCita = $this->CitaRepository->ConsultarUltimaCitaRegistrada();
                $Id_Cita = (int) $infoCita['Id_Cita'];

                // Programar llamada sobre cita agendada.
                // 1 -> sin confirmar
                if ($campos->Id_Estado_Cita == 1) {

                    $llamadaProgramada = new Llamada_Programada(
                        null,
                        null,
                        $Id_Cita,
                        null,
                        null,
                        $campos->Fecha_LP,
                        null
                    );

                    $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);

                    if ($respuesta !== true) {
                        return $this->respondWithData(["error" => $respuesta]);
                    }
                }
            } else {
                // Se valida si se programa llamada al cliente
                // Registrar llamada  programada.
                //  3 -> llamar nuevamente
                if ($campos->Id_Estado_Llamada == 3) {

                    $llamadaProgramada = new Llamada_Programada(
                        null,
                        $Id_Llamada,
                        null,
                        null,
                        null,
                        $campos->Fecha_LP,
                        null
                    );

                    $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);

                    if ($respuesta !== true) {
                        return $this->respondWithData(["error" => $respuesta]);
                    }
                }
            }

            if ($CitaRegistrada) {

                $infoOperador = $this->OperadorRepository->ObtenerDatosOperador((int) $campos->Id_Operador_Cita);

                // Registro de notificaciones
                $RegistroNotificacion = new RegistrarNotificaciones(
                    $this->logger,
                    $this->Notificaciones_UsuarioRepository,
                    $this->NotificacionRepository
                );
                
                // Registrar notificacion de cita registrada.
                $mensaje = "Cita agendada para " . $infoOperador['Nombre_Operador'] . ".";
                $notificacion = new Notificacion(
                    null,
                    $campos->Id_Usuario,
                    null,
                    $mensaje,
                    4
                );
                // Roles a los que desea notificar.
                $roles = array(1, 2);
                $RegistroNotificacion->RegistrarNotificacion($notificacion, $roles);
            }

            return $this->respondWithData(["ok" => $respuesta]);

        } catch (\Exception $e) {

            return $this->respondWithData(["error" => $e->getMessage()]);
        }
    }
}
