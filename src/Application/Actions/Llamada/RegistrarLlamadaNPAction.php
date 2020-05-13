<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Cliente\RegistrarCliente;
use App\Domain\Llamada\Llamada;
use App\Domain\Llamada_Programada\Llamada_Programada;
use App\Domain\Cita\Cita;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarLlamadaNPAction extends LlamadaAction
{
    protected function action(): Response
    {
        try {
            $respuesta = null;

            $campos = $this->getFormData();

            $llamada = new Llamada(
                NULL,
                $campos->Id_Usuario,
                NULL,
                $campos->Persona_Responde,
                NULL,
                $campos->Duracion_Llamada,
                $campos->Info_Habeas_Data,
                $campos->Observacion,
                $campos->Tipo_Llamada,
                $campos->Id_Estado_Llamada
            );

            if($campos->Validacion_Registro_Cliente){
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
                    $this->LineaRepository
                );

                $respuesta = $objCliente->RegistrarClientes($campos);

                if($respuesta !== true){
                    return $this->respondWithData(["error"=> $respuesta]);
                }

                $infoCliente = $this->ClienteRepository->ConsultarUltimoRegistrado();
                $Id_Cliente = (int) $infoCliente['Id_Cliente'];
                $llamada->__set("Id_Cliente",$Id_Cliente);
            }
            
            $respuesta = $this->LlamadaRepository->RegistrarLlamada($llamada);

            if($respuesta !== true){
                return $this->respondWithData(["error"=> $respuesta]);
            }

            $infoLlamada = $this->LlamadaRepository->ConsultarUltimaLlamada();
            $Id_Llamada = (int) $infoLlamada['Id_Llamada'];

            $CitaRegistrada = false;
            // Validar si se agenda cita
            if($campos->Validacion_Cita){

                $cita = new Cita(
                    NULL,
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
                    NULL,
                    NULL,
                    $campos->Id_Estado_Cita
                );
                
                $respuesta = $this->CitaRepository->RegistrarCita($cita);
                if($respuesta !== true){
                    return $this->respondWithData(["error"=> $respuesta]);
                }

                if($campos->Id_Estado_Cita == 2){
                    $CitaRegistrada = true;
                }
                
                $infoCita = $this->CitaRepository->ConsultarUltimaCitaRegistrada();
                $Id_Cita = (int) $infoCita['Id_Cita'];

                // Programar llamada sobre cita agendada.
                // 1 -> sin confirmar
                if($campos->Id_Estado_Cita == 1){

                    $llamadaProgramada = new Llamada_Programada(
                        NULL,
                        NULL,
                        $Id_Cita,
                        NULL,
                        NULL,
                        $campos->Fecha_LP,
                        NULL
                    );

                    $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);

                    if($respuesta !== true){
                        return $this->respondWithData(["error"=> $respuesta]);
                    }
                }
            }
            else{
                // Se valida si se programa llamada al cliente
                // Registrar llamada  programada.
                //  3 -> llamar nuevamente
                if($campos->Id_Estado_Llamada == 3){
                    
                    $llamadaProgramada = new Llamada_Programada(
                        NULL,
                        $Id_Llamada,
                        NULL,
                        NULL,
                        NULL,
                        $campos->Fecha_LP,
                        NULL
                    );

                    $respuesta = $this->Llamada_ProgramadaRepository->RegistrarLlamada_Programada($llamadaProgramada);

                    if($respuesta !== true){
                        return $this->respondWithData(["error"=> $respuesta]);
                    }
                }
            }
            
            if($CitaRegistrada){

                $infoOperador = $this->OperadorRepository->ObtenerDatosOperador((int) $campos->Id_Operador_Cita);

                $datosNotificacion = [
                    "Id_Cita" => $Id_Cita,
                    "Operador" => $infoOperador['Nombre_Operador']
                ];

                return $this->respondWithData(["ok"=> $respuesta, "okCita" => $CitaRegistrada,"notificacion" => $datosNotificacion]);

            }else{
                return $this->respondWithData(["ok"=> $respuesta, "okCita" => $CitaRegistrada]);
            } 
        } catch (\Exception $e) {

           return $this->respondWithData(["error"=> $e->getMessage()]);
        }
    }
}

