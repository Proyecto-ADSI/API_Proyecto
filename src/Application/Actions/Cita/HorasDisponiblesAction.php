<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use Psr\Http\Message\ResponseInterface as Response;

class HorasDisponiblesAction extends CitaAction
{
    protected function action(): Response
    {
        date_default_timezone_set("America/Bogota");
        $Id_Operador = (int) $this->resolveArg('Operador');
        $fecha = (int) $this->resolveArg("Fecha");
        $fecha =  date("Y-m-d", $fecha);
        $fecha .= "%";

        $infoConfig = $this->ConfiguracionRepository->ListarConfiguracion();
        $CitasXTCita = (int) $infoConfig['CitasXTCita'];
        $Tiempo_Inicio = strtotime($infoConfig['Tiempo_Laboral_Inicio']);
        $Tiempo_Fin = strtotime($infoConfig['Tiempo_Laboral_Fin']);
        // Tiempo cita
        $Duracion_Cita = $infoConfig['Duracion_Cita'];
        $Duracion_Cita = strtotime($Duracion_Cita);
        $horas = date("H", $Duracion_Cita);
        $minutos = date("i", $Duracion_Cita);
        $horas = (int) $horas;
        $minutos = (int) $minutos;
        $horasSeg = $horas * 3600;
        $minutosSeg = $minutos * 60;
        $segundos = $horasSeg + $minutosSeg;

        // Horas ocupadas para la fecha solicitada
        $horasOcupadas = $this->CitaRepository->ListarHorasCitas($Id_Operador, $fecha);
        // Array de horas.
        $arrayHoras = [];

        $Tiempo_Cita = $Tiempo_Inicio;

        while ($Tiempo_Cita <= $Tiempo_Fin) {
            $cantidad = 0;
            foreach ($horasOcupadas as $horaOcupada) {
                if (strtotime($horaOcupada['Hora']) == $Tiempo_Cita) {
                    $cantidad++;
                }
            }
            if ($CitasXTCita == 0) {
                $infoHora = [
                    "Hora" => date("H:i:s", $Tiempo_Cita),
                    "Cantidad" => $cantidad
                ];
                array_push($arrayHoras, $infoHora);
            } else {
                if ($cantidad < $CitasXTCita) {
                    $infoHora = [
                        "Hora" => date("H:i:s", $Tiempo_Cita),
                        "Cantidad" => $cantidad
                    ];
                    array_push($arrayHoras, $infoHora);
                }
            }
            $Tiempo_Cita = strtotime("+" . $segundos . " seconds", $Tiempo_Cita);
        }

        return $this->respondWithData(["Cantidad_Maxima" => $CitasXTCita, "Horas" => $arrayHoras]);
    }
}
